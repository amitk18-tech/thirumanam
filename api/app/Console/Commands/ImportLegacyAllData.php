<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

function normalizeBirthTime($value): ?string
{
    if (empty($value)) {
        return null;
    }

    // Normalize
    $v = mb_strtolower(trim($value), 'UTF-8');

    // Remove unwanted chars
    $v = str_replace(
        ['.', ' ', 'a:m', 'p:m'],
        ['', '', 'am', 'pm'],
        $v
    );

    // Convert 1023pm → 10:23pm
    if (preg_match('/^(\d{1,2})(\d{2})(am|pm)$/', $v, $m)) {
        $v = $m[1] . ':' . $m[2] . $m[3];
    }

    $formats = [
        'h:ia',
        'g:ia',
        'H:i',
        'G:i',
    ];

    foreach ($formats as $fmt) {
        try {
            return Carbon::createFromFormat($fmt, $v)
                ->format('h:i'); // 🔥 12-hour WITHOUT AM/PM
        } catch (\Exception $e) {
        }
    }

    return null;
}


class ImportLegacyAllData extends Command
{
    protected $signature = 'import:legacy-all';
    protected $description = 'Import legacy matrimony data (STREAM + SAFE for 20K+)';

    /* ================= HELPERS ================= */

    private function cleanDate($value)
    {
        if (empty($value) || $value === '0000-00-00 00:00:00') {
            return now();
        }

        try {
            $date = Carbon::parse($value);

            // Validate year is reasonable (between 1900 and current year + 10)
            if ($date->year < 1900 || $date->year > now()->year + 10) {
                return now();
            }

            return $date;
        } catch (\Exception $e) {
            return now();
        }
    }

    private function resolveCreatedAt(array $m)
    {
        $createdDate = $this->parseLegacyCreatedAt($m['created_date'] ?? null);
        if ($createdDate !== null) {
            return $createdDate;
        }

        $memberSince = $this->parseLegacyCreatedAt($m['member_since'] ?? null);
        if ($memberSince !== null) {
            return $memberSince;
        }

        return now();
    }

    private function parseLegacyCreatedAt($value)
    {
        if (empty($value)) {
            return null;
        }

        if ($value === '0000-00-00' || $value === '0000-00-00 00:00:00') {
            return null;
        }

        try {
            $date = Carbon::parse($value);

            // Guard against invalid parsed years (e.g., -0001 from zero-date values)
            if ($date->year < 1900 || $date->year > now()->year + 10) {
                return null;
            }

            return $date;
        } catch (\Exception $e) {
            return null;
        }
    }


    /* ================= USER ================= */


    protected function profileExists($id): bool
    {
        if (!$id) {
            return false;
        }

        return DB::table('profiles')
            ->where('id', (int) $id)
            ->exists();
    }


    private function parseRange($value): array
    {
        if (empty($value)) {
            return [null, null];
        }

        $txt = strtolower(trim($value));

        // normalize dash
        $txt = str_replace(['–', '—'], '-', $txt);

        // "160 to 175"
        if (strpos($txt, 'to') !== false) {
            [$a, $b] = explode('to', $txt);
            return [(int) trim($a), (int) trim($b)];
        }

        // "160-175"
        if (strpos($txt, '-') !== false) {
            [$a, $b] = explode('-', $txt);
            return [(int) trim($a), (int) trim($b)];
        }

        // "165"
        if (is_numeric($txt)) {
            return [(int) $txt, (int) $txt];
        }

        return [null, null];
    }


    private function deepJsonDecode($value)
    {
        $prev = null;

        while (is_string($value) && $value !== $prev) {
            $prev = $value;
            $decoded = json_decode($value, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                $value = $decoded;
            } else {
                break;
            }
        }

        return $value;
    }


    private function cleanIncome($value)
    {
        if (!$value)
            return null;

        $value = trim((string) $value);

        $value = str_replace(',', '', $value);

        if (strpos($value, '-') !== false) {
            $parts = explode('-', $value);
            $value = trim($parts[0]);
        }

        if (stripos($value, 'to') !== false) {
            $parts = explode('to', $value);
            $value = trim($parts[0]);
        }

        if (!is_numeric($value)) {
            return null;
        }

        $income = (float) $value;

        if ($income > 99999999) {
            return 99999999.99;
        }

        return $income;
    }

    private function userRoleId()
    {
        return DB::table('roles')->where('slug', 'user')->value('id')
            ?? DB::table('roles')->value('id');
    }

    /* ================= HELPERS ================= */

    private function normalizeCount($value)
    {
        if ($value === null) {
            return 0;
        }

        $value = trim((string) $value);

        if ($value === '' || $value === '-' || strtolower($value) === 'na') {
            return 0;
        }

        if (is_numeric($value)) {
            return (int) $value;
        }

        // Extract number from text like "2 Brothers"
        if (preg_match('/\d+/', $value, $matches)) {
            return (int) $matches[0];
        }

        return 0;
    }



    /* ================= MAIN ================= */

    public function handle()
    {
        $file = storage_path('app/legacy_members.json');

        if (!File::exists($file)) {
            $this->error('❌ JSON file not found');
            return;
        }

        $handle = fopen($file, 'r');
        if (!$handle) {
            $this->error('❌ Unable to open JSON file');
            return;
        }

        DB::beginTransaction();

        $buffer = '';
        $imported = 0;
        $skipped = 0;
        $skippedRecords = [];

        try {
            while (($line = fgets($handle)) !== false) {

                $line = trim($line);

                // Skip array start/end
                if ($line === '[' || $line === ']' || $line === '')
                    continue;

                $buffer .= $line;

                // End of one object
                if (str_ends_with($line, '}') || str_ends_with($line, '},')) {

                    $buffer = rtrim($buffer, ',');

                    $row = json_decode($buffer, true);

                    if (json_last_error() !== JSON_ERROR_NONE || !isset($row['member_id'])) {
                        $skipped++;
                        $skippedRecords[] = [
                            'error' => json_last_error_msg(),
                            'raw' => $buffer,
                        ];
                        $buffer = '';
                        continue;
                    }

                    // ✅ Import valid record
                    $this->importSingleMember($row);
                    $imported++;
                    $buffer = '';

                    // Commit every 50 records
                    if ($imported % 50 === 0) {
                        DB::commit();
                        DB::beginTransaction();
                        $this->info("Processed {$imported} records...");
                    }
                }
            }

            DB::commit();
            fclose($handle);

            // Save skipped records
            if (!empty($skippedRecords)) {
                File::put(
                    storage_path('app/skipped_legacy_members.json'),
                    json_encode($skippedRecords, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
                );
            }

            $this->info("✅ IMPORT COMPLETED | Imported: {$imported} | Skipped: {$skipped}");

        } catch (\Exception $e) {
            DB::rollBack();
            fclose($handle);
            $this->error('❌ ERROR: ' . $e->getMessage());
        }
    }

    /* ================= SINGLE RECORD ================= */

    private function importSingleMember(array $m)
    {
        /* ================= USER (FIXED – DUPLICATE SAFE) ================= */

        $createdAt = $this->resolveCreatedAt($m);

        $email = !empty($m['email']) ? strtolower(trim($m['email'])) : null;

        $mobile = !empty($m['mobile'])
            ? preg_replace('/\D+/', '', $m['mobile'])
            : null;

        // rendu-me illa na skip
        if (!$email && !$mobile) {
            return;
        }

        // 🚫 SKIP ONLY if prefixId is exactly 0
        if (
            isset($m['prefixId']) &&
            ($m['prefixId'] === '0' || $m['prefixId'] === 0)
        ) {
            return; // ❌ skip this record
        }

        $roleId = $this->userRoleId();

        // Find existing user by phone or email
        $existingUser = null;

        // email irundha mattum check pannalam
        if ($email) {
            $existingUser = DB::table('users')
                ->where('email', $email)
                ->first();
        }

        // ❗ mobile illana skip
        if (!$mobile) {
            return;
        }

        $roleId = $this->userRoleId();

        // ALWAYS INSERT NEW USER (no duplicate check, no update)
        $insertData = [
            'phone' => $mobile, // duplicate allowed
            'email' => $email,  // duplicate allowed
            'name' => trim(($m['first_name'] ?? '') . ' ' . ($m['last_name'] ?? '')),
            'role_id' => $roleId,

            // legacy password
            'password' => $m['password'] ?? null,

            'created_at' => $createdAt,
            'updated_at' => now(),
        ];

        $userId = DB::table('users')->insertGetId($insertData);



        /* ================= PROFILE ================= */

        $dob = null;
        $astro = [];
        if (!empty($m['astronomic_information'])) {
            $astro = is_string($m['astronomic_information'])
                ? (json_decode($m['astronomic_information'], true)[0] ?? [])
                : ($m['astronomic_information'][0] ?? []);

            if (!empty($astro['date_of_birth'])) {
                try {
                    $dob = Carbon::parse($astro['date_of_birth']);
                } catch (\Exception $e) {
                    $dob = null;
                }
            }
        }

        $addr = [];
        if (!empty($m['present_address'])) {
            $addr = is_string($m['present_address'])
                ? (json_decode($m['present_address'], true)[0] ?? [])
                : ($m['present_address'][0] ?? []);
        }

        $packinfo = [];
        if (!empty($m['package_info'])) {
            $packinfo = is_string($m['package_info'])
                ? (json_decode($m['package_info'], true)[0] ?? [])
                : ($m['package_info'][0] ?? []);
        }

        $edu = [];
        if (!empty($m['education_and_career'])) {
            $edu = is_string($m['education_and_career'])
                ? (json_decode($m['education_and_career'], true)[0] ?? [])
                : ($m['education_and_career'][0] ?? []);
        }

        $bas = [];
        if (!empty($m['basic_info'])) {
            $bas = is_string($m['basic_info'])
                ? (json_decode($m['basic_info'], true)[0] ?? [])
                : ($m['basic_info'][0] ?? []);
        }

        $registrationMode = 'online';

        if (!empty($m['member_type'])) {
            if ($m['member_type'] == 1) {
                $registrationMode = 'online';
            } elseif ($m['member_type'] == 2) {
                $registrationMode = 'offline';
            }
        }

        $packinfo = json_decode($m['package_info'] ?? '[]', true);

        /* ================= MEMBERSHIP MODE ================= */

        $membershipMode = 'online';

        if (
            !empty($packinfo[0]['payment_type']) &&
            strtoupper($packinfo[0]['payment_type']) === 'DIRECT_CASH'
        ) {
            $membershipMode = 'offline';
        }

        /* ================= PACKAGE NAME ================= */

        $packageName = 'default';

        if (!empty($packinfo[0]['current_package'])) {
            $packageName = strtolower(trim($packinfo[0]['current_package']));
        }

        /* ================= MARITAL STATUS (FIXED) ================= */

        $maritalStatus = null;

        if (!empty($bas['marital_status'])) {

            $rawStatus = strtolower(trim($bas['marital_status']));

            $statusMap = [
                // SINGLE
                'single' => 'never hookup',
                'unmarried' => 'never_married',
                'never married' => 'never_married',
                'separated' => 'separated',

                // DIVORCED
                'divorced' => 'divorced',
                'divorce' => 'divorced',
                'divorcee' => 'divorced',

                // WIDOWED
                'widowed' => 'widowed',
                'widow' => 'widowed',
                'widower' => 'widowed',
            ];

            $maritalStatus = $statusMap[$rawStatus] ?? null;
        }

        $dayOfBirth = null;

        if (!empty($astro['birthDay'])) {

            $rawDay = trim($astro['birthDay']);

            // normalize (remove spaces, newlines)
            $key = mb_strtolower(preg_replace('/\s+/u', '', $rawDay), 'UTF-8');

            // ENGLISH direct
            $englishDays = [
                'sunday',
                'monday',
                'tuesday',
                'wednesday',
                'thursday',
                'friday',
                'saturday'
            ];

            if (in_array($key, $englishDays, true)) {
                $dayOfBirth = $key;
            }

            // TAMIL keyword-based match
            elseif (str_contains($key, 'ஞாயிறு')) {
                $dayOfBirth = 'sunday';
            } elseif (str_contains($key, 'திங்கள்', )) {
                $dayOfBirth = 'monday';
            } elseif (str_contains($key, 'செவ்வாய்')) {
                $dayOfBirth = 'tuesday';
            } elseif (str_contains($key, 'புதன்கிழமை')) {
                $dayOfBirth = 'wednesday';
            } elseif (str_contains($key, 'வியாழக்கிழமை')) {
                $dayOfBirth = 'thursday';
            } elseif (str_contains($key, 'வெள்ளி')) {
                $dayOfBirth = 'friday';
            } elseif (str_contains($key, 'சனிக்கிழமை')) {
                $dayOfBirth = 'saturday';
            } // PLANET NAMES (ASTROLOGY)
            elseif (str_contains($key, 'mercury')) {
                $dayOfBirth = 'wednesday';
            } elseif (str_contains($key, 'saturn')) {
                $dayOfBirth = 'saturday';
            }
        }

        $dateOfBirth = null;

        if (!empty($m['date_of_birth'])) {

            if (is_numeric($m['date_of_birth'])) {

                $dateOfBirth = Carbon::createFromTimestamp((int) $m['date_of_birth'])
                    ->setTimezone('Asia/Kolkata') // 🔥 FIX
                    ->format('Y-m-d');

            } else {

                try {
                    $dateOfBirth = Carbon::parse($m['date_of_birth'])
                        ->format('Y-m-d');
                } catch (\Exception $e) {
                    $dateOfBirth = null;
                }
            }
        }

        // $paksha = null;

        // if (!empty($astro['PAKSHA'])) {

        //     $rawPaksha = mb_strtolower(trim($astro['PAKSHA']), 'UTF-8');

        //     // normalize spaces
        //     $rawPaksha = str_replace(['-', '_'], ' ', $rawPaksha);

        //     $pakshaMap = [

        //         'shukla' => 'shukla',
        //         'shukla paksha' => 'shukla',

        //         'krishna' => 'krishna',
        //         'krishna paksha' => 'krishna',

        //         'சுக்ல' => 'shukla',
        //         'கிருஷ்ண' => 'krishna',
        //     ];

        //     $paksha = $pakshaMap[$rawPaksha] ?? 'other';
        // }

        $paksha = null;

        if (!empty($astro['PAKSHA'])) {

            $originalPaksha = trim($astro['PAKSHA']);
            $rawPaksha = mb_strtolower($originalPaksha, 'UTF-8');

            // normalize
            $rawPaksha = str_replace(['-', '_'], ' ', $rawPaksha);

            $pakshaMap = [
                'shukla' => 'shukla',
                'shukla paksha' => 'shukla',

                'krishna' => 'krishna',
                'krishna paksha' => 'krishna',

                'சுக்ல' => 'shukla',
                'கிருஷ்ண' => 'krishna',
            ];

            // check mapped value
            if (isset($pakshaMap[$rawPaksha])) {

                $paksha = $pakshaMap[$rawPaksha];

            } else {

                // fallback → check Other_Paksha
                $otherPaksha = $astro['Other_Paksha'] ?? null;

                // validate (avoid garbage like date)
                if (!empty($otherPaksha) && !preg_match('/^\d{4}-\d{2}-\d{2}$/', $otherPaksha)) {
                    $paksha = trim($otherPaksha);
                } else {
                    $paksha = $originalPaksha; // last fallback
                }
            }
        }

        $tithi = null;

        if (!empty($astro['TITHI'])) {

            $raw = mb_strtolower(trim($astro['TITHI']), 'UTF-8');
            $raw = str_replace([' ', '-', '_'], '', $raw);

            $tithiMap = [
                'prathama' => 'prathama',
                'dwitha' => 'dwitha',
                'tritiya' => 'tritiya',
                'chadurthi' => 'chadurthi',
                'panchami' => 'panchami',
                'shashti' => 'shashti',
                'saptami' => 'saptami',
                'ashtami' => 'ashtami',
                'navami' => 'navami',
                'dashami' => 'dashami',
                'ekadashi' => 'ekadashi',
                'dwadashi' => 'dwadashi',
                'thiryodashi' => 'thiryodashi',
                'chaturdasi' => 'chaturdasi',
                'purnima' => 'purnima',
                'amavasya' => 'amavasya',
            ];

            $tithi = $tithiMap[$raw] ?? null;
        }

        $rasi = null;

        if (!empty($astro['rashi'])) {

            // normalize: lowercase + trim + remove spaces/_/-
            $raw = mb_strtolower(trim($astro['rashi']), 'UTF-8');
            $raw = str_replace([' ', '-', '_'], '', $raw);

            $rasiMap = [
                'aries' => 'aries',
                'taurus' => 'taurus',
                'gemini' => 'gemini',
                'cancer' => 'cancer',
                'leo' => 'leo',
                'virgo' => 'virgo',
                'libra' => 'libra',
                'scorpio' => 'scorpio',
                'sagittarius' => 'sagittarius',
                'capricorn' => 'capricorn',
                'aquarius' => 'aquarius',
                'pisces' => 'pisces',
            ];

            $rasi = $rasiMap[$raw] ?? null;
        }



        $star = null;

        if (!empty($astro['star'])) {

            $raw = mb_strtolower(trim($astro['star']), 'UTF-8');
            $raw = str_replace([' ', '-', '_'], '', $raw);

            $starMap = [

                'ashwini' => 'ashwini',

                'bharani' => 'bharani',
                'barani' => 'bharani',

                'karthigai' => 'krittika',
                'karthikai' => 'krittika',
                'krittika' => 'krittika',

                'rohini' => 'rohini',

                'mirugasridam' => 'mirugastridam',
                'mirugasiridam' => 'mirugastridam',
                'mrigashira' => 'mirugastridam',

                'thiruvadhirai' => 'thiruvadhirai',
                'thiruvathirai' => 'thiruvadhirai',
                'ardra' => 'thiruvadhirai',

                'punarpoosam' => 'punarpoosam',
                'punarvasu' => 'punarpoosam',

                'poosam' => 'poosam',
                'pushya' => 'poosam',

                'Ayilyam' => 'Ayilyam',
                'ayilyam' => 'Ayilyam',
                'ashlesha' => 'Ayilyam',

                'magam' => 'magam',
                'magha' => 'magam',

                'pooram' => 'pooram',
                'purvaphalguni' => 'pooram',

                'uthiram' => 'uthiram',
                'uttaraphalguni' => 'uthiram',

                'astham' => 'astham',
                'hasta' => 'astham',

                'chithirai' => 'chithirai',
                'chitra' => 'chithirai',

                'Swathi' => 'Swathi',
                'swathi' => 'Swathi',
                'swati' => 'Swathi',

                'visakam' => 'visakam',
                'vishakha' => 'visakam',

                'anusham' => 'anusham',
                'anuradha' => 'anusham',

                'kettai' => 'kettai',
                'jyeshtha' => 'kettai',

                'mulam' => 'mulam',
                'mula' => 'mulam',

                'puradam' => 'puradam',
                'purvaashadha' => 'puradam',

                'uthiradam' => 'uthiradam',
                'uttaraashadha' => 'uthiradam',

                'thiruvonam' => 'thiruvonam',
                'shravana' => 'thiruvonam',

                'avittam' => 'avittam',
                'dhanishta' => 'avittam',

                'sadayam' => 'sadayam',
                'shatabhisha' => 'sadayam',

                'purattadhi' => 'purattadhi',
                'purattathi' => 'purattadhi',
                'purvabhadrapada' => 'purattadhi',

                'uthrattadhi' => 'uthrattadhi',
                'uthirattadhi' => 'uthrattadhi',
                'uttarabhadrapada' => 'uthrattadhi',

                'revathi' => 'revathi',
                'revati' => 'revathi',
            ];

            $star = $starMap[$raw] ?? null;
        }


        $lakknam = null;

        if (!empty($astro['LAKKNAM'])) {

            // normalize: lowercase + trim + remove spaces/_/-
            $raw = mb_strtolower(trim($astro['LAKKNAM']), 'UTF-8');
            $raw = str_replace([' ', '-', '_'], '', $raw);

            $lakknamMap = [
                'aries' => 'aries',
                'taurus' => 'taurus',
                'gemini' => 'gemini',
                'cancer' => 'cancer',
                'leo' => 'leo',
                'virgo' => 'virgo',
                'libra' => 'libra',
                'scorpio' => 'scorpio',
                'sagittarius' => 'sagittarius',
                'capricorn' => 'capricorn',
                'aquarius' => 'aquarius',
                'pisces' => 'pisces',
            ];

            $lakknam = $lakknamMap[$raw] ?? null;
        }

        $directionalBalance = null;

        if (!empty($astro['DIRECTIONAL_BALANCE'])) {

            $raw = mb_strtolower(trim($astro['DIRECTIONAL_BALANCE']), 'UTF-8');
            $raw = str_replace([' ', '-', '_'], '', $raw);

            $planetMap = [
                'sun' => 'sun',
                'moon' => 'moon',
                'mars' => 'mars',
                'mercury' => 'mercury',
                'jupiter' => 'jupiter',
                'venus' => 'venus',
                'saturn' => 'saturn',
                'rahu' => 'rahu',
                'ragu' => 'rahu',
                'ketu' => 'ketu',
                'kethu' => 'ketu',
            ];

            $directionalBalance = $planetMap[$raw] ?? null;
        }

        $horoscopeMatching = null;

        if (!empty($astro['HOROSCOPE_MATCHING'])) {

            $raw = mb_strtolower(trim($astro['HOROSCOPE_MATCHING']), 'UTF-8');
            $raw = str_replace([' ', '-', '_'], '', $raw);

            $matchMap = [
                // EXACT
                'exact' => 'exactly',
                'exactly' => 'exactly',
                'full' => 'exactly',
                'yes' => 'exactly',

                // PARTIAL
                'partial' => 'partially',
                'partially' => 'partially',
                'semi' => 'partially',
                'no' => 'partially',

                // CAPS legacy
                'exactmatch' => 'exactly',
                'partialmatch' => 'partially',

                // Tamil safety (optional)
                'முழுமை' => 'exactly',
                'பகுதி' => 'partially',
            ];

            $horoscopeMatching = $matchMap[$raw] ?? null;
        }

        $dosham = null;

        if (!empty($astro['DOSHAM'])) {

            // normalize
            $raw = mb_strtolower(trim($astro['DOSHAM']), 'UTF-8');
            $raw = str_replace([' ', '-', '_'], '', $raw);

            $doshamMap = [
                'yes' => 'yes',
                'y' => 'yes',
                'present' => 'yes',
                'exists' => 'yes',
                'true' => 'yes',
                '1' => 'yes',

                'no' => 'no',
                'n' => 'no',
                'absent' => 'no',
                'none' => 'no',
                'false' => 'no',
                '0' => 'no',

                'yesdosham' => 'yes',
                'nodosham' => 'no',

                'உண்டு' => 'yes',
                'இல்லை' => 'no',
            ];

            $dosham = $doshamMap[$raw] ?? null;
        }


        $padam = null;

        if (!empty($astro['PADAM'])) {

            $raw = strtolower(trim($astro['PADAM']));

            // remove space dash underscore
            $raw = preg_replace('/[\s\-_]+/', '', $raw);

            if ($raw === 'padam0')
                $padam = 'padam0';
            elseif ($raw === 'padam1')
                $padam = 'padam_1';
            elseif ($raw === 'padam2')
                $padam = 'padam_2';
            elseif ($raw === 'padam3')
                $padam = 'padam_3';
            elseif ($raw === 'padam4')
                $padam = 'padam_4';
            elseif ($raw === 'padam')
                $padam = 'padam';

            // fallback
            else if (preg_match('/(\d)/', $raw, $m)) {
                $padam = 'padam_' . $m[1];
            }
        }

        $typeOfDosham = null;

        if (!empty($astro['TYPE_OF_DOSHAM'])) {

            $raw = mb_strtolower(trim($astro['TYPE_OF_DOSHAM']), 'UTF-8');

            $raw = str_replace(['-', '_'], ' ', $raw);
            $raw = preg_replace('/\s+/', ' ', $raw);

            if (str_contains($raw, 'ragu') && str_contains($raw, 'kethu') && str_contains($raw, 'mars')) {
                $typeOfDosham = 'ragu_kethu_mars';

            } elseif (str_contains($raw, 'ragu') && str_contains($raw, 'kethu')) {
                $typeOfDosham = 'ragu_kethu';

            } elseif (str_contains($raw, '7') && str_contains($raw, 'saturn')) {
                $typeOfDosham = '7_saturn';

            } elseif (str_contains($raw, '2') && str_contains($raw, 'mars')) {
                $typeOfDosham = '2_mars';

            } elseif (str_contains($raw, '4') && str_contains($raw, 'mars')) {
                $typeOfDosham = '4_mars';

            } elseif (str_contains($raw, '7') && str_contains($raw, 'mars')) {
                $typeOfDosham = '7_mars';

            } elseif (str_contains($raw, '8') && str_contains($raw, 'mars')) {
                $typeOfDosham = '8_mars';

            } elseif (str_contains($raw, '12') && str_contains($raw, 'mars')) {
                $typeOfDosham = '12_mars';

            } elseif (str_contains($raw, 'remedial') || str_contains($raw, 'pariharam')) {
                $typeOfDosham = 'remedial_horoscope';

            } elseif (str_contains($raw, 'clean') || str_contains($raw, 'சுத்த')) {
                $typeOfDosham = 'clean_horoscope';

            } else {
                $typeOfDosham = 'others';
            }
        }

        $year = null;
        $month = null;
        $day = null;

        /* ---------- DECODE ---------- */

        if (!empty($m['astronomic_information'])) {

            $astro = is_string($m['astronomic_information'])
                ? (json_decode($m['astronomic_information'], true)[0] ?? [])
                : ($m['astronomic_information'][0] ?? []);

            // 🔥 parse numbers safely
            $year = $this->parseNumberSafe($astro['Year'] ?? null);
            $month = $this->parseNumberSafe($astro['Month'] ?? null);
            $day = $this->parseNumberSafe($astro['Day'] ?? null);
        }

        if (!empty($m['present_address'])) {
            $addr = is_string($m['present_address'])
                ? (json_decode($m['present_address'], true)[0] ?? [])
                : ($m['present_address'][0] ?? []);
        }

        $physical = [];
        if (!empty($m['physical_attributes'])) {
            $physical = is_string($m['physical_attributes'])
                ? (json_decode($m['physical_attributes'], true)[0] ?? [])
                : ($m['physical_attributes'][0] ?? []);
        }

        /* ADDRESS PICK LOGIC */

        $present = json_decode($m['present_address'] ?? '[]', true)[0] ?? [];
        $permanent = json_decode($m['permanent_address'] ?? '[]', true)[0] ?? [];

        $addr = !empty($present) ? $present : $permanent;

        /* normalize common keys */
        $addrCountry = $addr['country']
            ?? ($permanent['permanent_country'] ?? null);

        $addrState = $addr['state']
            ?? ($permanent['permanent_state'] ?? null);

        $addrCity = $addr['city']
            ?? ($permanent['permanent_city'] ?? null)
            ?? ($permanent['permanent_city_other'] ?? null);

        $presentPostalCode = $this->nullIfEmpty($addr['postal_code'] ?? null);
        $permanentPostalCode = $this->nullIfEmpty(
            $permanent['permanent_postal_code']
            ?? $permanent['postal_code']
            ?? null
        );

        $addrPostal = $presentPostalCode ?? $permanentPostalCode;

        $addrAddress = $addr['address'] ?? null;


        $childrenLivingPlace = null;

        if (!empty($bas['Child_living_place'])) {

            $raw = strtolower(trim($bas['Child_living_place']));

            Log::info('Legacy child living place', [
                'user_id' => $userId,
                'raw' => $raw
            ]);

            if (
                str_contains($raw, 'living') &&
                str_contains($raw, 'me') &&
                !str_contains($raw, 'not')
            ) {
                $childrenLivingPlace = 'living_with_me';

            } elseif (
                str_contains($raw, 'not') ||
                str_contains($raw, 'separate') ||
                str_contains($raw, 'away')
            ) {
                $childrenLivingPlace = 'not_living_with_me';
            }

            Log::info('Mapped child living place', [
                'user_id' => $userId,
                'final' => $childrenLivingPlace
            ]);
        }

        $education = null;

        if (!empty($edu['Type_of_study'])) {

            $original = trim($edu['Type_of_study']);

            $raw = mb_strtolower($original, 'UTF-8');

            // normalize
            $raw = str_replace(['-', '_'], ' ', $raw);
            $raw = preg_replace('/\s+/', ' ', $raw);

            // 🔥 smart mapping
            if (str_contains($raw, 'bachelor') && str_contains($raw, 'engineering')) {
                $education = 'bachelors_engineering';

            } elseif (str_contains($raw, 'master') && str_contains($raw, 'engineering')) {
                $education = 'masters_engineering';

            } elseif (
                str_contains($raw, 'master') && (
                    str_contains($raw, 'arts') ||
                    str_contains($raw, 'science') ||
                    str_contains($raw, 'commerce')
                )
            ) {
                $education = 'masters_arts_science_commerce/others';

            } elseif (
                str_contains($raw, 'bachelor') && (
                    str_contains($raw, 'arts') ||
                    str_contains($raw, 'science') ||
                    str_contains($raw, 'commerce')
                )
            ) {
                $education = 'bachelors_arts_science_commerce/others';

            } elseif (str_contains($raw, 'mba') || str_contains($raw, 'bba') || str_contains($raw, 'management')) {
                $education = 'management_bba_mba/others';

            } elseif (str_contains($raw, 'law') || str_contains($raw, 'llb') || str_contains($raw, 'llm')) {
                $education = 'legal_bl_ml_llb_llm/others';

            } elseif (str_contains($raw, 'ias') || str_contains($raw, 'ips') || str_contains($raw, 'service')) {
                $education = 'service_ias_ips/others';

            } elseif (str_contains($raw, 'phd')) {
                $education = 'phd';

            } elseif (str_contains($raw, 'diploma')) {
                $education = 'diploma';

            } elseif (str_contains($raw, 'higher') || str_contains($raw, 'secondary')) {
                $education = 'higher_secondary/secondary';

            } elseif (str_contains($raw, 'medical') || str_contains($raw, 'doctor') || str_contains($raw, 'dental')) {
                $education = 'medicine_general_dental_surgeon_others';

            } else {

                // 🔥 fallback to other_study
                $other = $edu['other_study'] ?? null;

                if (!empty($other)) {
                    $education = trim($other);
                } else {
                    $education = $original; // last fallback
                }
            }
        }

        $occupation = null;

        if (!empty($edu['Type_of_occupation'])) {

            $original = trim($edu['Type_of_occupation']);

            $raw = mb_strtolower($original, 'UTF-8');

            // normalize
            $raw = str_replace(['-', '_'], ' ', $raw);
            $raw = preg_replace('/\s+/', ' ', $raw);

            // 🔥 smart mapping
            if (
                str_contains($raw, 'gov') ||
                str_contains($raw, 'government')
            ) {
                $occupation = 'government';

            } elseif (
                str_contains($raw, 'private')
            ) {
                $occupation = 'private';

            } elseif (
                str_contains($raw, 'business')
            ) {
                $occupation = 'business';

            } elseif (
                str_contains($raw, 'self') ||
                str_contains($raw, 'own') ||
                str_contains($raw, 'freelance')
            ) {
                $occupation = 'self_employed';

            } elseif (
                str_contains($raw, 'not working') ||
                str_contains($raw, 'unemployed') ||
                $raw === '--'
            ) {
                $occupation = 'not_working';

            } elseif (
                str_contains($raw, 'defence') ||
                str_contains($raw, 'army') ||
                str_contains($raw, 'navy') ||
                str_contains($raw, 'air force')
            ) {
                $occupation = 'defence';

            } else {

                // 🔥 fallback to Other_Occupation_Details
                $other = $edu['Other_Occupation_Details'] ?? null;

                if (!empty($other)) {
                    $occupation = trim($other);
                } else {
                    $occupation = $original; // last fallback
                }
            }
        }



        DB::table('profiles')->updateOrInsert(
            ['user_id' => $userId],
            [
                /* BASIC */
                'gender' => ($m['gender'] ?? '1') == '1' ? 'male' : 'female',
                'dob' => optional($dob)->format('Y-m-d'), // ✅ FIXED
                'age' => optional($dob)->age,
                'marital_status' => $maritalStatus,
                'number_of_children' => $this->normalizeCount($bas['number_of_children'] ?? null),
                'children_living_place' => $childrenLivingPlace,
                'registration_mode' => $registrationMode, // ✅ FIXED
                'membership_type' => $packageName, // ✅ Using resolved slug
                'mobile' => $m['mobile'] ?? null,
                'introduction' => $this->truncateText($m['introduction'] ?? null, 255),

                /* ADDRESS */
                'country' => $addrCountry,
                'state' => $this->normalizeState($addrState),
                'city' => $addrCity,
                'address' => $addrAddress,
                'postal_code' => $addrPostal,
                'alternate_number' => $permanent['alternate_number'] ?? null,
                'landline' => $permanent['landline'] ?? null,
                /* PHYSICAL */
                'height' => $m['height'] ?? null,

                'weight' => !empty($physical['weight']) && $physical['weight'] !== '--'
                    ? (int) $physical['weight']
                    : null,

                'eye_color' => !empty($physical['eye_color']) && $physical['eye_color'] !== '--'
                    ? $physical['eye_color']
                    : null,

                'hair_color' => !empty($physical['hair_color']) && $physical['hair_color'] !== '--'
                    ? $physical['hair_color']
                    : null,

                'complexion' => !empty($physical['complexion']) && $physical['complexion'] !== '--'
                    ? $physical['complexion']
                    : null,

                'body_type' => !empty($physical['body_type']) && $physical['body_type'] !== '--'
                    ? $physical['body_type']
                    : null,

                'physical_status' => !empty($physical['any_disability']) && $physical['any_disability'] !== '--'
                    ? $physical['any_disability']
                    : null,

                'blood_group' => !empty($physical['blood_group']) && $physical['blood_group'] !== '--'
                    ? strtoupper($physical['blood_group'])
                    : null,
                'date_of_birth' => $dateOfBirth,
                /* EDUCATION & CAREER */
                'education' => $education,
                'occupation' => $occupation,
                'study_details' => $edu['STUDY_DETAILS'] ?? null,
                'career_profile' => $edu['Career_Profile'] ?? null,
                'earnings' => strtolower($edu['Earnings'] ?? ''),
                'income_amount' => $this->cleanIncome($edu['annual_income'] ?? null),
                'income' => $edu['annual_income'] ?? null,

                /* ASTRONOMIC */
                'day_of_birth' => $dayOfBirth,
                'birth_time' => ($astro['time_of_birth'] ?? null),
                'paksha' => $paksha,
                'star' => $star,
                'rasi' => $rasi,
                'padam' => $padam,
                'lakknam' => $lakknam,
                'horoscope_matching' => $horoscopeMatching,
                'other_dosham' => $astro['Other_Dosham'] ?? null,
                'dosham' => $dosham,
                'year' => $year,
                'month' => $month,
                'day' => $day,
                'tithi' => $tithi,
                'type_of_dosham' => $typeOfDosham,
                'directional_balance' => $directionalBalance,
                'birth_place' => $astro['city_of_birth'] ?? null,
                'birth_country' => $addr['country'] ?? null,
                'birth_state' => $this->normalizeState($addr['state'] ?? null),
                'birth_city' => $astro['city_of_birth'] ?? null,
                /* META */
                'created_at' => $createdAt,
                'updated_at' => now(),
            ]
        );

        $profileId = DB::table('profiles')->where('user_id', $userId)->value('id');

        /* ================= ADDRESS ================= */
        $present = json_decode($m['present_address'] ?? '[]', true)[0] ?? [];
        $permanent = json_decode($m['permanent_address'] ?? '[]', true)[0] ?? [];

        DB::table('addresses')->updateOrInsert(
            ['profile_id' => $profileId],
            [

                // PRESENT ADDRESS
                'country' => $present['country'] ?? null,
                'state' => $this->normalizeState($present['state'] ?? null),
                'city' => $present['city'] ?? null,
                'address' => $present['address'] ?? null,
                'postal_code' => $addrPostal ?? null,

                // PERMANENT INFO mapped into existing fields
                'native_place' => $permanent['permanent_city'] ?? null,
                'current_city' => $present['city'] ?? null,

                'mobile' => $permanent['mobile']
                    ?? $permanent['alternate_number']
                    ?? $m['mobile']
                    ?? null,

                'alternate_number' => $permanent['alternate_number'] ?? null,
                'landline' => $permanent['landline'] ?? null,

                'updated_at' => now(),
                'created_at' => $createdAt,
            ]
        );


        /* ================= PHYSICAL ATTRIBUTES ================= */

        $physical_attributes = [];

        if (!empty($m['physical_attributes'])) {
            $physical_attributes = json_decode($m['physical_attributes'], true);

            // If decode fails, fallback
            if (!is_array($physical_attributes)) {
                $physical_attributes = [];
            }
        }

        // Take first record
        $physical = $physical_attributes[0] ?? null;

        if (!empty($physical)) {

            DB::table('physical_attributes')->updateOrInsert(
                ['profile_id' => $profileId],
                [
                    'height' => !empty($physical['height']) && $physical['height'] !== '--'
                        ? (float) $physical['height']
                        : null,

                    'weight' => !empty($physical['weight']) && $physical['weight'] !== '--'
                        ? (int) $physical['weight']
                        : null,

                    'eye_color' => !empty($physical['eye_color']) && $physical['eye_color'] !== '--'
                        ? $physical['eye_color']
                        : null,

                    'hair_color' => !empty($physical['hair_color']) && $physical['hair_color'] !== '--'
                        ? $physical['hair_color']
                        : null,

                    'complexion' => !empty($physical['complexion']) && $physical['complexion'] !== '--'
                        ? $physical['complexion']
                        : null,

                    'body_type' => !empty($physical['body_type']) && $physical['body_type'] !== '--'
                        ? $physical['body_type']
                        : null,

                    'physical_status' => !empty($physical['any_disability']) && $physical['any_disability'] !== '--'
                        ? $physical['any_disability']
                        : null,

                    'blood_group' => !empty($physical['blood_group']) && $physical['blood_group'] !== '--'
                        ? strtoupper($physical['blood_group'])
                        : null,

                    'updated_at' => now(),
                    'created_at' => $createdAt,
                ]
            );



            /* ================= EDUCATION ================= */
            $edu = json_decode($m['education_and_career'] ?? '[]', true)[0] ?? null;

            if ($edu) {
                DB::table('education_careers')->updateOrInsert(
                    ['profile_id' => $profileId],
                    [
                        // Education
                        'education' => $edu['Type_of_study'] ?? null,
                        'study_details' => $edu['STUDY_DETAILS'] ?? null,

                        // Career
                        'occupation' => $edu['Type_of_occupation'] ?? null,
                        'career_profile' => $edu['Career_Profile'] ?? null,

                        // Earnings
                        'earnings' => strtolower($edu['Earnings'] ?? null),
                        'income' => $edu['annual_income'] ?? null,
                        'income_amount' => $this->cleanIncome($edu['annual_income'] ?? null),
                        'created_at' => $createdAt,
                        'updated_at' => now(),
                    ]
                );
            }


            /* ================= FAMILY ================= */

            // helper
            $famData = is_string($m['family_info'] ?? null)
                ? json_decode($m['family_info'], true)
                : $m['family_info'];

            $fam = is_array($famData) && isset($famData[0]) ? $famData[0] : [];

            $spiritualData = is_string($m['spiritual_and_social_background'] ?? null)
                ? json_decode($m['spiritual_and_social_background'], true)
                : $m['spiritual_and_social_background'];

            $spiritual = is_array($spiritualData) && isset($spiritualData[0]) ? $spiritualData[0] : [];

            /* ===== FAMILY TYPE ===== */
            $familyType = null;

            if (!empty($fam['family_type'])) {

                $rawFamilyType = mb_strtolower(trim($fam['family_type']), 'UTF-8');

                // normalize symbols
                $rawFamilyType = str_replace(['-', '_'], ' ', $rawFamilyType);

                // remove extra spaces
                $rawFamilyType = preg_replace('/\s+/', ' ', $rawFamilyType);

                $familyTypeMap = [
                    'joint' => 'joint',
                    'joint family' => 'joint',

                    'nuclear' => 'nuclear',
                    'nuclear family' => 'nuclear',

                    'separate' => 'nuclear',
                    'separated' => 'nuclear',
                ];

                $familyType = $familyTypeMap[$rawFamilyType] ?? null;
            }


            $rawPropertyDescription =
                $fam['Property_Description']
                ?? $fam['property_description']
                ?? null;

            $rawOtherPropertyDescription =
                $fam['Other_Property_Description']
                ?? $fam['Other_property_description']
                ?? $fam['other_property_description']
                ?? null;

            $propertyDescription = null;

            if (!empty($rawPropertyDescription) || !empty($rawOtherPropertyDescription)) {

                $original = trim((string) $rawPropertyDescription);
                $other = trim((string) $rawOtherPropertyDescription);

                $raw = mb_strtolower($original, 'UTF-8');

                // normalize for detection
                $normalized = str_replace(['-', '_', ','], ' ', $raw);
                $normalized = preg_replace('/\s+/', ' ', $normalized);

                $normalizedOriginalToken = str_replace(['-', '_'], ' ', mb_strtoupper($original, 'UTF-8'));
                $normalizedOriginalToken = preg_replace('/\s+/', ' ', trim($normalizedOriginalToken));

                // 🔥 1. ALL FACILITIES
                if (str_contains($normalized, 'all') && str_contains($normalized, 'facil')) {

                    $propertyDescription = 'All facilities';

                    // 🔥 2. HOUSE
                } elseif (str_contains($normalized, 'வீடு') || str_contains($normalized, 'house')) {

                    if (str_contains($normalized, '5')) {
                        $propertyDescription = 'Own house 5 or 5 above';
                    } elseif (str_contains($normalized, '4')) {
                        $propertyDescription = 'Own House 4';
                    } elseif (str_contains($normalized, '3')) {
                        $propertyDescription = 'Own House 3';
                    } elseif (str_contains($normalized, '2')) {
                        $propertyDescription = 'Own House 2';
                    } else {
                        $propertyDescription = 'Own House 1';
                    }

                    // 🔥 3. LAND
                } elseif (str_contains($normalized, 'land') || str_contains($normalized, 'நிலம்') || str_contains($normalized, 'இடம்')) {

                    if (str_contains($normalized, '5')) {
                        $propertyDescription = 'Vacant land 5 or above';
                    } elseif (str_contains($normalized, '4')) {
                        $propertyDescription = 'Land in Galle 4';
                    } elseif (str_contains($normalized, '3')) {
                        $propertyDescription = 'Land in Galle 3';
                    } elseif (str_contains($normalized, '2')) {
                        $propertyDescription = 'Land in Galle 2';
                    } else {
                        $propertyDescription = 'Land in Galle 1';
                    }

                    // 🔥 4. LOOM
                } elseif (str_contains($normalized, 'loom')) {

                    if (str_contains($normalized, '5')) {
                        $propertyDescription = 'Loom 5 or 5 above';
                    } elseif (str_contains($normalized, '4')) {
                        $propertyDescription = 'Loom 4';
                    } elseif (str_contains($normalized, '3')) {
                        $propertyDescription = 'Loom 3';
                    } elseif (str_contains($normalized, '2')) {
                        $propertyDescription = 'Loom 2';
                    } else {
                        $propertyDescription = 'Loom 1';
                    }

                    // 🔥 5. OTHERS (IMPORTANT FIX)
                } elseif (
                    $normalizedOriginalToken === 'OTHERS' ||
                    $normalizedOriginalToken === 'OTHER' ||
                    $normalizedOriginalToken === 'மற்றவை'
                ) {

                    $propertyDescription = $other !== '' ? $other : $original;

                    // 🔥 6. FINAL FALLBACK
                } else {

                    $propertyDescription = $original ?: null;
                }
            }

            /* ===== INSERT ===== */
            if (!empty($fam)) {

                DB::table('family_details')->updateOrInsert(
                    ['profile_id' => $profileId],
                    [
                        'surname' => $fam['Surname'] ?? null,

                        'father_name' => $fam['father'] ?? null,
                        'mother_name' => $fam['mother'] ?? null,

                        'father_vangusam' => $this->mapVangusam(
                            $fam['father_vangusam'] ?? null,
                            $fam['other_father_vang'] ?? null
                        ),

                        'mother_vangusam' => $this->mapVangusam(
                            $fam['mother_vangusam'] ?? null,
                            $fam['other_mother_vang'] ?? null
                        ),

                        'brothers_count' => $this->normalizeCount($fam['Number_of_brothers'] ?? null),
                        'brothers_married' => $this->normalizeCount($fam['Number_of_married_brothers'] ?? null),

                        'sisters_count' => $this->normalizeCount($fam['Number_of_Sisters'] ?? null),
                        'sisters_married' => $this->normalizeCount($fam['Number_of_married_sisters'] ?? null),

                        'family_type' => $familyType,

                        'property_description' => $propertyDescription,
                        'property_description_other' => $this->nullIfEmpty($rawOtherPropertyDescription),

                        'soveran_details' => $m['soveran_detail'] ?? null,

                        'family_status' => $spiritual['family_status'] ?? null,
                        'family_values' => $spiritual['family_value'] ?? null,
                        'about_family' => $spiritual['about_family'] ?? null,

                        'updated_at' => $createdAt,
                        'created_at' => $createdAt,
                    ]
                );
            }

            /* ================= HOROSCOPE BOXES (144 Keys) ================= */
            $rawChart = $m['chart'] ?? [];

            if (\is_string($rawChart)) {
                $decodedChart = json_decode($rawChart, true);
                $chartJson = \is_array($decodedChart) ? $decodedChart : [];
            } elseif (\is_array($rawChart)) {
                $chartJson = $rawChart;
            } else {
                $chartJson = [];
            }

            $rashiData = $chartJson['rashi'] ?? ((isset($chartJson[0]) && \is_array($chartJson[0])) ? $chartJson[0] : []);

            if (\is_array($rashiData) && !empty($rashiData)) {

                $zodiacAndFeatures = $this->getZodiacAndFeatures($rashiData);

                DB::table('horoscope_boxes')->where('profile_id', $profileId)->delete();

                $batchInserts = [];

                $zodiacBoxes = $zodiacAndFeatures['zodiac'];
                foreach ($zodiacBoxes as $boxIndex => $boxItems) {
                    for ($item = 0; $item < 6; $item++) {
                        $value = $boxItems[$item] ?? '';

                        $batchInserts[] = [
                            'profile_id' => $profileId,
                            'box_number' => $boxIndex + 1,
                            'item_number' => $item + 1,
                            'type' => 'ZODIAC',
                            'value' => trim($value),
                            'created_at' => $createdAt,
                            'updated_at' => now(),
                        ];
                    }
                }

                $featureBoxes = $zodiacAndFeatures['feature'];
                foreach ($featureBoxes as $boxIndex => $boxItems) {
                    for ($item = 0; $item < 6; $item++) {
                        $value = $boxItems[$item] ?? '';

                        $batchInserts[] = [
                            'profile_id' => $profileId,
                            'box_number' => $boxIndex + 1,
                            'item_number' => $item + 1,
                            'type' => 'FEATURE',
                            'value' => trim($value),
                            'created_at' => $createdAt,
                            'updated_at' => now(),
                        ];
                    }
                }

                $this->info("Batch inserts count: " . count($batchInserts) . " (expected 144)");
                Log::info('Horoscope batch insert count', [
                    'profile_id' => $profileId,
                    'total_records' => count($batchInserts),
                    'zodiac_boxes' => count($zodiacBoxes),
                    'feature_boxes' => count($featureBoxes),
                ]);

                if (count($batchInserts) !== 144) {
                    Log::warning('Unexpected horoscope records count for profile_id: ' . $profileId, [
                        'expected' => 144,
                        'actual' => count($batchInserts),
                    ]);
                }

                if (!empty($batchInserts)) {
                    DB::table('horoscope_boxes')->insert($batchInserts);
                    $this->info("Inserted " . count($batchInserts) . " horoscope records for profile_id: " . $profileId);
                }
            }


            /* ================= PARTNER ================= */

            $partner = [];

            if (!empty($m['partner_expectation'])) {
                $partner = is_string($m['partner_expectation'])
                    ? (json_decode($m['partner_expectation'], true)[0] ?? [])
                    : ($m['partner_expectation'][0] ?? []);
            }


            [$preferredAgeMin, $preferredAgeMax] =
                $this->parseAgeSafe($partner['partner_age'] ?? null);

            [$preferredHeightMin, $preferredHeightMax] =
                $this->parseHeightSafe($partner['partner_height'] ?? null);

            $weight = $this->parseWeightSafe($partner['partner_weight'] ?? null);

            $familyType = null;

            if (!empty($fam['family_type'])) {

                $rawFamilyType = strtolower(trim($fam['family_type']));

                $familyTypeMap = [
                    'joint' => 'joint',
                    'joint family' => 'joint',
                    'nuclear' => 'nuclear',
                    'nuclear family' => 'nuclear',
                    'separate' => 'nuclear',
                    'separated' => 'nuclear',
                ];

                $familyType = $familyTypeMap[$rawFamilyType] ?? null;
            }

            $typeOfDosham = null;

            if (!empty($partner['partner_TYPE_OF_DOSHAM'])) {

                $raw = mb_strtolower(trim($partner['partner_TYPE_OF_DOSHAM']), 'UTF-8');
                $raw = str_replace(['-', '_'], ' ', $raw);
                $raw = preg_replace('/\s+/', ' ', $raw);

                if (str_contains($raw, 'ragu') && str_contains($raw, 'kethu') && str_contains($raw, 'mars'))
                    $typeOfDosham = 'ragu_kethu_mars';
                elseif (str_contains($raw, 'ragu') && str_contains($raw, 'kethu'))
                    $typeOfDosham = 'ragu_kethu';
                elseif (str_contains($raw, '7') && str_contains($raw, 'saturn'))
                    $typeOfDosham = '7_saturn';
                elseif (str_contains($raw, '2') && str_contains($raw, 'mars'))
                    $typeOfDosham = '2_mars';
                elseif (str_contains($raw, '4') && str_contains($raw, 'mars'))
                    $typeOfDosham = '4_mars';
                elseif (str_contains($raw, '7') && str_contains($raw, 'mars'))
                    $typeOfDosham = '7_mars';
                elseif (str_contains($raw, '8') && str_contains($raw, 'mars'))
                    $typeOfDosham = '8_mars';
                elseif (str_contains($raw, '12') && str_contains($raw, 'mars'))
                    $typeOfDosham = '12_mars';
                elseif (str_contains($raw, 'remedial') || str_contains($raw, 'pariharam'))
                    $typeOfDosham = 'remedial_horoscope';
                elseif (str_contains($raw, 'clean') || str_contains($raw, 'சுத்த'))
                    $typeOfDosham = 'clean_horoscope';
                else
                    $typeOfDosham = 'others';
            }

            $dosham = null;

            if (!empty($partner['partner_DOSHAM'])) {

                $raw = mb_strtolower(trim($partner['partner_DOSHAM']), 'UTF-8');
                $raw = str_replace([' ', '-', '_'], '', $raw);

                $doshamMap = [
                    'yes' => 'yes',
                    'y' => 'yes',
                    'present' => 'yes',
                    'true' => 'yes',
                    '1' => 'yes',
                    'no' => 'no',
                    'n' => 'no',
                    'absent' => 'no',
                    'false' => 'no',
                    '0' => 'no',
                    'yesdosham' => 'yes',
                    'nodosham' => 'no',
                    'உண்டு' => 'yes',
                    'இல்லை' => 'no',
                ];

                $dosham = $doshamMap[$raw] ?? null;
            }

            $maritalStatus = null;

            $expectData = is_string($m['partner_expectation'] ?? null)
                ? json_decode($m['partner_expectation'], true)
                : $m['partner_expectation'];

            $expect = is_array($expectData) && isset($expectData[0]) ? $expectData[0] : [];

            if (!empty($expect['partner_marital_status'])) {

                $rawStatus = mb_strtolower(trim($expect['partner_marital_status']), 'UTF-8');

                // normalize
                $rawStatus = str_replace(['-', '_'], ' ', $rawStatus);
                $rawStatus = preg_replace('/\s+/', ' ', $rawStatus);

                // 🔥 smart detection
                if (
                    str_contains($rawStatus, 'single') ||
                    str_contains($rawStatus, 'unmarried') ||
                    str_contains($rawStatus, 'never') ||
                    str_contains($rawStatus, 'naver') ||
                    str_contains($rawStatus, 'maried') ||
                    str_contains($rawStatus, 'not married')
                ) {
                    $maritalStatus = 'never_married';

                } elseif (
                    str_contains($rawStatus, 'divorc')
                ) {
                    $maritalStatus = 'divorced';

                } elseif (
                    str_contains($rawStatus, 'separ')
                ) {
                    $maritalStatus = 'separated';

                } elseif (
                    str_contains($rawStatus, 'widow') ||
                    str_contains($rawStatus, 'widowed')
                ) {
                    $maritalStatus = 'widowed';

                } else {
                    $maritalStatus = null; // or 'never_married' if default வேண்டும்னா
                }

                Log::info('Mapped marital status', [
                    'raw' => $rawStatus,
                    'final' => $maritalStatus
                ]);
            }
            $childrenAcceptable = null;

            /* decode partner_expectation */
            $partner = json_decode($m['partner_expectation'] ?? '[]', true)[0] ?? [];

            if (isset($partner['with_children_acceptables'])) {

                $raw = strtolower(trim($partner['with_children_acceptables']));

                Log::info('Legacy children acceptable', [
                    'profile_id' => $profileId,
                    'raw' => $raw
                ]);

                if ($raw === 'yes') {
                    $childrenAcceptable = 'Yes';

                } elseif ($raw === 'no') {
                    $childrenAcceptable = 'No';

                } else {
                    $childrenAcceptable = "Doesn't Matter";
                }

                Log::info('Mapped children acceptable', [
                    'profile_id' => $profileId,
                    'final' => $childrenAcceptable
                ]);
            }

            $expectation = null;

            $rawPartnerExpectation = trim((string) (
                $partner['partner_Expectation']
                ?? $partner['partner_expectation']
                ?? ''
            ));

            $rawPartnerOtherExpectation = trim((string) (
                $partner['partner_Other_Expectation']
                ?? $partner['partner_Other_expectation']
                ?? $partner['partner_other_expectation']
                ?? ''
            ));

            if ($rawPartnerExpectation !== '' || $rawPartnerOtherExpectation !== '') {

                $expectationToken = str_replace(
                    ['-', '_'],
                    ' ',
                    mb_strtoupper($rawPartnerExpectation, 'UTF-8')
                );
                $expectationToken = preg_replace('/\s+/', ' ', trim($expectationToken));

                if (
                    $expectationToken === 'OTHERS' ||
                    $expectationToken === 'OTHER' ||
                    $expectationToken === 'மற்றவை'
                ) {
                    // If legacy selected "Other", keep custom text in expectations field.
                    $expectation = $rawPartnerOtherExpectation !== ''
                        ? $rawPartnerOtherExpectation
                        : $rawPartnerExpectation;
                } elseif ($rawPartnerExpectation !== '') {
                    $expectation = $rawPartnerExpectation;
                } else {
                    $expectation = $rawPartnerOtherExpectation;
                }
            }

            DB::table('partner_preferences')->updateOrInsert(
                ['profile_id' => $profileId],
                [

                    'age' => $preferredAgeMin,
                    'preferred_age_max' => $preferredAgeMax,
                    'height' => $preferredHeightMin,
                    'preferred_height_max' => $preferredHeightMax,
                    'weight' => $weight,
                    'marital_status' => $maritalStatus,
                    'children_acceptables' => $childrenAcceptable,
                    'education' => $this->nullIfEmpty($partner['partner_education'] ?? null),
                    'occupation' => $this->nullIfEmpty($partner['partner_profession'] ?? null),
                    'body_type' => $this->nullIfEmpty($partner['partner_body_type'] ?? null),
                    'dosham' => $dosham,
                    'type_of_dosham' => $typeOfDosham,
                    'other_dosham' => $this->nullIfEmpty($partner['partner_Other_Dosham'] ?? null),
                    'expectations' => $this->nullIfEmpty($expectation),
                    'religion' => $spiritual['religion'] ?? null,
                    'caste' => $spiritual['caste'] ?? null,
                    'family_type' => $familyType ?? null,
                    'horoscope_required' =>
                        (($partner['horoscope_required'] ?? '') === 'yes'),
                    'created_at' => $createdAt,
                    'updated_at' => now(),
                ]
            );


            /* ================= ASTRONOMIC ================= */

            $astro = [];
            $addr = [];

            $year = null;
            $month = null;
            $day = null;

            /* ---------- DECODE ---------- */

            if (!empty($m['astronomic_information'])) {

                $astro = is_string($m['astronomic_information'])
                    ? (json_decode($m['astronomic_information'], true)[0] ?? [])
                    : ($m['astronomic_information'][0] ?? []);
                $year = $this->parseNumberSafe($astro['Year'] ?? null);
                $month = $this->parseNumberSafe($astro['Month'] ?? null);
                $day = $this->parseNumberSafe($astro['Day'] ?? null);
            }

            if (!empty($m['present_address'])) {
                $addr = is_string($m['present_address'])
                    ? (json_decode($m['present_address'], true)[0] ?? [])
                    : ($m['present_address'][0] ?? []);
            }

            /* ---------- TYPE OF DOSHAM ---------- */

            $typeOfDosham = null;

            if (!empty($astro['TYPE_OF_DOSHAM'])) {

                $raw = mb_strtolower(trim($astro['TYPE_OF_DOSHAM']), 'UTF-8');
                $raw = str_replace(['-', '_'], ' ', $raw);
                $raw = preg_replace('/\s+/', ' ', $raw);

                if (str_contains($raw, 'ragu') && str_contains($raw, 'kethu') && str_contains($raw, 'mars'))
                    $typeOfDosham = 'ragu_kethu_mars';
                elseif (str_contains($raw, 'ragu') && str_contains($raw, 'kethu'))
                    $typeOfDosham = 'ragu_kethu';
                elseif (str_contains($raw, '7') && str_contains($raw, 'saturn'))
                    $typeOfDosham = '7_saturn';
                elseif (str_contains($raw, '2') && str_contains($raw, 'mars'))
                    $typeOfDosham = '2_mars';
                elseif (str_contains($raw, '4') && str_contains($raw, 'mars'))
                    $typeOfDosham = '4_mars';
                elseif (str_contains($raw, '7') && str_contains($raw, 'mars'))
                    $typeOfDosham = '7_mars';
                elseif (str_contains($raw, '8') && str_contains($raw, 'mars'))
                    $typeOfDosham = '8_mars';
                elseif (str_contains($raw, '12') && str_contains($raw, 'mars'))
                    $typeOfDosham = '12_mars';
                elseif (str_contains($raw, 'remedial') || str_contains($raw, 'pariharam'))
                    $typeOfDosham = 'remedial_horoscope';
                elseif (str_contains($raw, 'clean') || str_contains($raw, 'சுத்த'))
                    $typeOfDosham = 'clean_horoscope';
                else
                    $typeOfDosham = 'others';
            }

            /* ---------- PADAM ---------- */

            $padam = null;

            if (!empty($astro['PADAM'])) {

                $raw = strtolower(trim($astro['PADAM']));
                $raw = preg_replace('/[\s\-_]+/', '', $raw);

                if ($raw === 'padam0')
                    $padam = 'padam0';
                elseif ($raw === 'padam1')
                    $padam = 'padam_1';
                elseif ($raw === 'padam2')
                    $padam = 'padam_2';
                elseif ($raw === 'padam3')
                    $padam = 'padam_3';
                elseif ($raw === 'padam4')
                    $padam = 'padam_4';
                elseif ($raw === 'padam')
                    $padam = 'padam';
                else if (preg_match('/(\d)/', $raw, $m))
                    $padam = 'padam_' . $m[1];
            }

            /* ---------- SAVE TO DB ---------- */

            if ($astro) {

                DB::table('astronomic_information')->updateOrInsert(
                    ['profile_id' => $profileId],
                    [

                        'star' => $star,
                        'rasi' => $rasi,
                        'padam' => $padam,
                        'dosham' => $dosham,
                        'tithi' => $tithi,
                        'paksha' => $paksha,
                        'date_of_birth' => $dateOfBirth,
                        'birth_country' => $addr['country'] ?? null,
                        'birth_state' => $this->normalizeState($addr['state'] ?? null),
                        'day_of_birth' => $dayOfBirth,
                        'type_of_dosham' => $typeOfDosham,
                        'birth_city' => isset($astro['city_of_birth'])
                            ? trim((string) $astro['city_of_birth'])
                            : (isset($astro['birth_city'])
                                ? trim((string) $astro['birth_city'])
                                : null),
                        'year' => $year,
                        'month' => $month,
                        'day' => $day,
                        'horoscope_matching' => $horoscopeMatching,
                        'charan' => $astro['charan'] ?? null,
                        'ganam' => $astro['ganam'] ?? null,
                        'lakknam' => $lakknam,
                        'birth_time' => normalizeBirthTime($astro['time_of_birth'] ?? null),
                        'birth_place' => $astro['city_of_birth'] ?? null,
                        'directional_balance' => $directionalBalance,
                        'created_at' => $createdAt,
                        'updated_at' => now(),
                    ]
                );
            }

            $reportedProfiles = json_decode($m['report_profile'] ?? '[]', true);

            if (is_array($reportedProfiles) && count($reportedProfiles) > 0) {

                // who reported
                $fromProfileId = DB::table('profiles')
                    ->where('user_id', $userId)
                    ->value('id');

                foreach ($reportedProfiles as $oldMemberId) {

                    // legacy member id -> new profile id
                    $toProfileId = DB::table('members')
                        ->where('legacy_member_id', $oldMemberId)
                        ->value('profile_id');

                    if (!$fromProfileId || !$toProfileId) {
                        continue;
                    }

                    DB::table('profile_reports')->updateOrInsert(
                        [
                            'reported_by_profile_id' => $fromProfileId,
                            'reported_profile_id' => $toProfileId,
                        ],
                        [
                            'reason' => 'legacy_import',
                            'description' => null,
                            'created_at' => $createdAt,
                            'updated_at' => now(),
                        ]
                    );
                }
            }

            /* ================= PACKAGE INFO ================= */

            $packinfo = json_decode($m['package_info'] ?? '[]', true);

            /* ================= MEMBERSHIP MODE ================= */

            $membershipMode = 'online';

            if (
                !empty($packinfo[0]['payment_type']) &&
                strtoupper($packinfo[0]['payment_type']) === 'DIRECT_CASH'
            ) {
                $membershipMode = 'offline';
            }

            /* ================= PACKAGE NAME ================= */
            $packageName = 'default';

            if (!empty($packinfo[0]['current_package'])) {
                $packageName = strtolower(trim($packinfo[0]['current_package']));
            }

            /* ================= MEMBERSHIP ID ================= */

            $membershipId = DB::table('memberships')
                ->where('slug', $packageName)
                ->where('membership_mode', $membershipMode)
                ->value('id');

            if (!$membershipId) {
                $membershipId = DB::table('memberships')
                    ->where('slug', 'default')
                    ->value('id');
            }

            /* ================= START DATE ================= */

            $startDate = $this->cleanDate(
                $m['membership_date']
                ?? $m['member_since']
                ?? null
            );

            /* ================= END DATE (FIXED) ================= */

            $durationDays = DB::table('memberships')
                ->where('id', $membershipId)
                ->value('duration_days') ?? 0;

            if ($durationDays > 0) {
                $endDate = (clone $startDate)->addDays($durationDays);
            } else {

                $endDate = clone $startDate;
            }

            $defaultSentInterest = (int) DB::table('memberships')
                ->where('id', $membershipId)
                ->value('sent_interest_allowed') ?? 0;

            $defaultProfileView = (int) DB::table('memberships')
                ->where('id', $membershipId)
                ->value('profiles_view_allowed') ?? 0;

            $defaultMessages = (int) DB::table('memberships')
                ->where('id', $membershipId)
                ->value('messages_sent_allowed') ?? 0;


            $expressInterest = (int) ($m['express_interest'] ?? 0);
            $remainDownload = (int) ($m['remain_download'] ?? 0);
            $directMessages = (int) ($m['direct_messages'] ?? 0);


            /* ================= INSERT / UPDATE MEMBER ================= */

            $reportedIds = json_decode($m['report_profile'] ?? '[]', true);
            $lastReportedId = null;

            if (is_array($reportedIds) && !empty($reportedIds)) {
                $lastReportedId = end($reportedIds); // integer column → last reported id
            }

            DB::table('members')->updateOrInsert(
                ['profile_id' => $profileId],
                [
                    'membership_id' => $membershipId ?? 1,
                    'start_date' => $startDate,
                    'end_date' => $endDate,
                    'sent_interest_allowed' => $defaultSentInterest,
                    'profiles_view_allowed' => $defaultProfileView,
                    'messages_sent_allowed' => $defaultMessages,
                    'sent_interest_remaining' => $expressInterest,
                    'profiles_view_remaining' => $remainDownload,
                    'messages_sent_remaining' => $directMessages,
                    'report_profile' => $lastReportedId,
                    'is_matched' => (int) ($m['is_married'] ?? 0) === 1,
                    'status' => $this->getMemberStatus($m),
                    'is_verified' => ($m['email_verification_status'] ?? 0) == 1,
                    'verified_by_admin' => ($m['status'] ?? '') === 'approved',
                    'blocked_by_admin' => ($m['is_blocked'] ?? 'no') === 'yes',
                    'is_deleted' => ($m['delete_status'] ?? '0') === '1',
                    'isRenewed' => (int) ($m['isRenewed'] ?? 0),
                    'is_closed' => array_key_exists('is_closed', $m)
                        ? (
                            $m['is_closed'] === null || trim($m['is_closed']) === ''
                            ? null
                            : (strtolower(trim($m['is_closed'])) === 'yes' ? 'yes' : 'no')
                        )
                        : null,
                    'prefix_id' => $m['prefixId'] ?? null,
                    'membership_expired' => ($durationDays ?? 0) > 0
                        ? now()->gt($endDate ?? now())
                        : false,
                    'auto_renewal' => false,
                    'send_reminder' => false,
                    'member_no' => $m['member_profile_id'] ?? null,
                    'legacy_member_id' => $m['member_id'] ?? null,
                    'created_at' => $createdAt,
                    'updated_at' => now(),
                ]
            );
        }

        $followed = json_decode($m['followed'] ?? '[]', true);

        if (is_array($followed)) {
            foreach ($followed as $oldMemberId) {

                $toProfileId = DB::table('members')
                    ->where('legacy_member_id', $oldMemberId)
                    ->value('profile_id');

                if (!$toProfileId)
                    continue;
                DB::table('profile_actions')->updateOrInsert(
                    [
                        'from_profile_id' => $profileId,
                        'to_profile_id' => $toProfileId,
                        'action_type' => 'follow',
                    ],
                    [
                        'created_at' => $createdAt,
                        'updated_at' => now(),
                    ]
                );
            }
        }

        $blocked = json_decode($m['blocked'] ?? '[]', true);

        if (is_array($blocked)) {
            foreach ($blocked as $oldMemberId) {
                $toProfileId = DB::table('members')
                    ->where('legacy_member_id', $oldMemberId)
                    ->value('profile_id');
                if (!$toProfileId)
                    continue;
                DB::table('profile_actions')->updateOrInsert(
                    [
                        'from_profile_id' => $profileId,
                        'to_profile_id' => $toProfileId,
                        'action_type' => 'block',
                    ],
                    [
                        'created_at' => $createdAt,
                        'updated_at' => now(),
                    ]
                );
            }
        }

        $shortlisted = json_decode($m['shortlisted'] ?? '[]', true);

        if (is_array($shortlisted)) {
            foreach ($shortlisted as $oldMemberId) {

                $toProfileId = DB::table('members')
                    ->where('legacy_member_id', $oldMemberId)
                    ->value('profile_id');

                if (!$toProfileId)
                    continue;

                DB::table('profile_actions')->updateOrInsert(
                    [
                        'from_profile_id' => $profileId,
                        'to_profile_id' => $toProfileId,
                        'action_type' => 'shortlist',
                    ],
                    [
                        'created_at' => $createdAt,
                        'updated_at' => now(),
                    ]
                );
            }
        }

    }


    private function getMemberStatus(array $m): string
    {
        $status = 'inactive';

        $isClosed = ($m['is_closed'] ?? 'no') === 'yes';
        $isProfileIncomplete = ($m['updateProfileDoneStatus'] ?? 0) == 0;
        $isDeleted = ($m['delete_status'] ?? 0) == 1;
        $isDeactivated = ($m['deactivate_status'] ?? 0) == 1;

        // Step 1: membership expiry check
        if (!empty($m['membership_date'])) {
            try {
                $expiryDate = Carbon::parse($m['membership_date'])->addMonths(6);

                if (now()->gt($expiryDate)) {
                    $status = 'expired';
                } else {
                    $status = 'active';
                }

            } catch (\Exception $e) {
                $status = 'inactive';
            }
        }

        // Step 2: other conditions override
        if ($isClosed || $isProfileIncomplete || $isDeleted || $isDeactivated) {
            $status = 'inactive';
        }

        return $status;
    }


    // private function getMemberStatus(array $m): string
    // {
    //     $isClosed = ($m['is_closed'] ?? 'no') === 'yes';
    //     $isProfileIncomplete = ($m['updateProfileDoneStatus'] ?? 0) == 0;
    //     $isDeleted = ($m['delete_status'] ?? 0) == 1;
    //     $isDeactivated = ($m['deactivate_status'] ?? 0) == 1;

    //     // Membership expiry check (6 months from membership_date)
    //     $membershipExpired = false;

    //     if (!empty($m['membership_date'])) {
    //         try {
    //             $expiryDate = Carbon::parse($m['membership_date'])->addMonths(6);
    //             $membershipExpired = now()->gt($expiryDate);
    //         } catch (\Exception $e) {
    //             $membershipExpired = true;
    //         }
    //     } else {
    //         $membershipExpired = true;
    //     }

    //     LOG::info('Member status check', [
    //         'profile_id' => $m['profile_id'] ?? null,
    //         'is_closed' => $isClosed,
    //         'is_profile_incomplete' => $isProfileIncomplete,
    //         'is_deleted' => $isDeleted,
    //         'is_deactivated' => $isDeactivated,
    //         'membership_expired' => $membershipExpired,
    //         'data' => $m,
    //     ]);
    //     // Final decision
    //     if ($isClosed || $isProfileIncomplete || $isDeleted || $isDeactivated || $membershipExpired) {
    //         return 'inactive';
    //     }

    //     return 'active';
    // }

    private function getZodiacAndFeatures(array $rashi)
    {
        $values = array_values($rashi);

        $groupsOfSix = array_chunk($values, 6);

        if (count($groupsOfSix) !== 24) {
            Log::warning('Invalid horoscope structure', [
                'profile_id' => $profileId ?? null,
                'count' => count($groupsOfSix),
            ]);
            return [
                'zodiac' => [],
                'feature' => [],
            ];
        }

        foreach ($groupsOfSix as $g) {
            if (!is_array($g) || count($g) !== 6) {
                return [
                    'zodiac' => [],
                    'feature' => [],
                ];
            }
        }

        $zodiac = array_slice($groupsOfSix, 0, 12);
        $feature = array_slice($groupsOfSix, 12, 12);

        return [
            'zodiac' => $zodiac,
            'feature' => $feature,
        ];
    }

    private function nullIfEmpty($value)
    {
        if ($value === '' || $value === 'null' || $value === 'NULL') {
            return null;
        }
        return $value;
    }

    private function truncateText($value, int $maxLength)
    {
        if ($value === null) {
            return null;
        }

        $text = trim((string) $value);

        if ($text === '') {
            return null;
        }

        if (mb_strlen($text, 'UTF-8') <= $maxLength) {
            return $text;
        }

        return rtrim(mb_substr($text, 0, $maxLength, 'UTF-8'));
    }

    private function parseAgeSafe($value)
    {
        if (!$value)
            return [null, null];

        preg_match_all('/\d+/', $value, $matches);

        $min = isset($matches[0][0]) ? (int) $matches[0][0] : null;
        $max = isset($matches[0][1]) ? (int) $matches[0][1] : null;

        return [$min, $max];
    }

    private function parseHeightSafe($value)
    {
        if (!$value)
            return [null, null];

        preg_match_all('/\d+(\.\d+)?/', $value, $matches);

        $min = isset($matches[0][0]) ? (float) $matches[0][0] : null;
        $max = isset($matches[0][1]) ? (float) $matches[0][1] : null;

        return [$min, $max];
    }

    private function parseWeightSafe($value)
    {
        if (!$value)
            return null;

        $value = strtolower(trim($value));

        if (
            str_contains($value, 'ft') ||
            str_contains($value, 'height') ||
            str_contains($value, 'any')
        ) {
            return null;
        }

        preg_match('/\d+/', $value, $match);

        return isset($match[0]) ? (int) $match[0] : null;
    }

    private function mapVangusam($value, $other = null)
    {
        if (empty($value))
            return null;

        $original = trim($value);

        $raw = mb_strtoupper($original, 'UTF-8');

        // normalize
        $raw = str_replace(['-', '_', '.', ','], '', $raw);
        $raw = preg_replace('/\s+/', '', $raw);

        $validOptions = [
            'IRUMANER',
            'LADHIKAR',
            'ENTHELAR',
            'KAPPELAR',
            'AMBUGULNAR',
            'BOJALAR',
            'KANJALAKUNDADAR',
            'BALALER(VISHNU)',
            'BALALER(SHIVA)',
            'SEVELAR',
            'MARALELAR',
            'GUDIGELAR',
            'KADUBELAR',
            'PAWTHAMALNER',
            'MALALER',
            'ADARNADAR',
            'SIDHUKOLDHAR',
            'PANNETHAR',
            'ALLKULNELARU',
            'ANNALER',
            'ARAGANATHAR',
            'BALITHAR',
            'BALILAR',
            'CHINNUKATTAR',
            'MALIDHAR',
            'MINGILAR',
            'MUCHALADHAR',
            'PAVALATHAR',
            'THUBBELAR',
            'BAANILAR',
            'APPUKOLDHAR',
            'ALLIKANDER',
            'BANIYAR',
            'KORADHAR',
            'MATHALEDAR',
            'PAJALER',
            'MUTHUNDHAR',
        ];

        // ✅ exact match
        if (in_array($raw, $validOptions)) {
            return $raw;
        }

        // ✅ partial match
        foreach ($validOptions as $option) {
            $cleanOption = str_replace(['(', ')'], '', $option);

            if (str_contains($raw, $cleanOption)) {
                return $option;
            }
        }

        // ✅ fallback to other field
        if (!empty($other)) {
            return trim($other);
        }

        // ✅ last fallback (no data loss)
        return $original;
    }

    private function mapPropertyDescription($value, $other = null)
    {
        if (empty($value) && empty($other))
            return null;

        $original = trim($value ?? '');

        $raw = mb_strtolower(trim(($value ?? '') . ' ' . ($other ?? '')), 'UTF-8');

        // normalize
        $raw = str_replace(['-', '_', ',', '.'], ' ', $raw);
        $raw = preg_replace('/\s+/', ' ', $raw);

        // 🔥 HOUSE
        if (str_contains($raw, 'வீடு') || str_contains($raw, 'house')) {

            if (str_contains($raw, '5'))
                return 'Own house 5 or 5 above';
            if (str_contains($raw, '4'))
                return 'Own House 4';
            if (str_contains($raw, '3'))
                return 'Own House 3';
            if (str_contains($raw, '2'))
                return 'Own House 2';

            return 'Own House 1';
        }

        // 🔥 LAND
        if (str_contains($raw, 'land') || str_contains($raw, 'நிலம்') || str_contains($raw, 'இடம்')) {

            if (str_contains($raw, '5'))
                return 'Vacant land 5 or above';
            if (str_contains($raw, '4'))
                return 'Land in Galle 4';
            if (str_contains($raw, '3'))
                return 'Land in Galle 3';
            if (str_contains($raw, '2'))
                return 'Land in Galle 2';

            return 'Land in Galle 1';
        }

        // 🔥 LOOM
        if (str_contains($raw, 'loom')) {

            if (str_contains($raw, '5'))
                return 'Loom 5 or 5 above';
            if (str_contains($raw, '4'))
                return 'Loom 4';
            if (str_contains($raw, '3'))
                return 'Loom 3';
            if (str_contains($raw, '2'))
                return 'Loom 2';

            return 'Loom 1';
        }

        // 🔥 ALL FACILITIES
        if (str_contains($raw, 'all') && str_contains($raw, 'facil')) {
            return 'All facilities';
        }

        // 🔥 fallback to other
        if (!empty($other)) {
            return trim($other);
        }

        // 🔥 last fallback (no data loss)
        return $original ?: null;
    }

    private function normalizeState($value)
    {
        if (!$value)
            return null;

        $raw = mb_strtolower(trim($value), 'UTF-8');
        $raw = str_replace(['-', '_'], ' ', $raw);
        $raw = preg_replace('/\s+/', ' ', $raw);

        $map = [

            'andhra pradesh' => 'andhra_pradesh',
            'arunachal pradesh' => 'arunachal_pradesh',
            'assam' => 'assam',
            'bihar' => 'bihar',
            'chhattisgarh' => 'chhattisgarh',
            'goa' => 'goa',
            'gujarat' => 'gujarat',
            'haryana' => 'haryana',
            'himachal pradesh' => 'himachal_pradesh',
            'jharkhand' => 'jharkhand',
            'karnataka' => 'karnataka',
            'kerala' => 'kerala',
            'madhya pradesh' => 'madhya_pradesh',
            'maharashtra' => 'maharashtra',
            'manipur' => 'manipur',
            'meghalaya' => 'meghalaya',
            'mizoram' => 'mizoram',
            'nagaland' => 'nagaland',
            'odisha' => 'odisha',
            'orissa' => 'odisha',
            'punjab' => 'punjab',
            'rajasthan' => 'rajasthan',
            'sikkim' => 'sikkim',

            'tamilnadu' => 'tamil_nadu',
            'tamil nadu' => 'tamil_nadu',
            'tn' => 'tamil_nadu',

            'telangana' => 'telangana',
            'tripura' => 'tripura',
            'uttar pradesh' => 'uttar_pradesh',
            'uttarakhand' => 'uttarakhand',
            'west bengal' => 'west_bengal',

            'andaman nicobar' => 'andaman_nicobar',
            'andaman and nicobar islands' => 'andaman_nicobar',

            'chandigarh' => 'chandigarh',

            'dadra nagar haveli daman diu' => 'dadra_nagar_haveli_daman_diu',

            'delhi' => 'delhi',
            'new delhi' => 'delhi',

            'jammu kashmir' => 'jammu_kashmir',

            'ladakh' => 'ladakh',
            'lakshadweep' => 'lakshadweep',
            'puducherry' => 'puducherry',
            'pondicherry' => 'puducherry',
        ];

        return $map[$raw] ?? null;
    }

    private function parseNumberSafe($value)
    {
        if (!$value)
            return null;

        preg_match('/\d+/', $value, $match);

        return isset($match[0]) ? (int) $match[0] : null;
    }

}