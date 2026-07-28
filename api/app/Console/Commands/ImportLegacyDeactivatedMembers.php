<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;

class ImportLegacyDeactivatedMembers extends Command
{
    protected $signature = 'import:legacy-deactivated-members';
    protected $description = 'Import legacy deactivated members data from JSON file';

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

        // Remove commas
        $value = str_replace(',', '', $value);

        // Handle ranges like "100000-200000" - take the first value
        if (strpos($value, '-') !== false) {
            $parts = explode('-', $value);
            $value = trim($parts[0]);
        }

        // Handle ranges with "to" like "100000 to 200000"
        if (stripos($value, 'to') !== false) {
            $parts = explode('to', $value);
            $value = trim($parts[0]);
        }

        if (!is_numeric($value)) {
            return null;
        }

        $income = (float) $value;

        // Cap at reasonable maximum (99 million)
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
        $file = storage_path('app/deactivated_member.json');

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

        $email = !empty($m['email']) ? strtolower(trim($m['email'])) : null;

        $mobile = !empty($m['mobile'])
            ? preg_replace('/\D+/', '', $m['mobile'])
            : null;

        // rendu-me illa na skip
        if (!$email && !$mobile) {
            return;
        }

        $roleId = $this->userRoleId();

        // Find existing user by phone or email
        $existingUser = DB::table('users')
            ->where(function ($query) use ($mobile, $email) {
                if ($mobile) {
                    $query->orWhere('phone', $mobile);
                }
                if ($email) {
                    $query->orWhere('email', $email);
                }
            })
            ->first();

        // Check if email already used by ANOTHER user
        $emailAlreadyUsed = false;

        if ($email) {
            $emailAlreadyUsed = DB::table('users')
                ->where('email', $email)
                ->when($existingUser, function ($q) use ($existingUser) {
                    $q->where('id', '!=', $existingUser->id);
                })
                ->exists();
        }

        if ($existingUser) {

            // UPDATE USER
            $updateData = [
                'phone' => $mobile ?: $existingUser->phone,
                'name' => trim(($m['first_name'] ?? '') . ' ' . ($m['last_name'] ?? '')),
                'role_id' => $roleId,
                'updated_at' => now(),
            ];

            // ✅ email only if NOT duplicate
            if ($email && !$emailAlreadyUsed) {
                $updateData['email'] = $email;
            }

            DB::table('users')
                ->where('id', $existingUser->id)
                ->update($updateData);

            $userId = $existingUser->id;

        } else {

            // INSERT USER
            $insertData = [
                'phone' => $mobile,
                'name' => trim(($m['first_name'] ?? '') . ' ' . ($m['last_name'] ?? '')),
                'role_id' => $roleId,
                'password' => bcrypt('password'),
                'created_at' => $this->cleanDate($m['created_date']) ?? now(),
                'updated_at' => now(),
            ];

            // ✅ email only if unique
            if ($email && !DB::table('users')->where('email', $email)->exists()) {
                $insertData['email'] = $email;
            }

            $userId = DB::table('users')->insertGetId($insertData);
        }


        /* ================= PROFILE ================= */

        $dob = null;
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

        $edu = [];
        if (!empty($m['education_and_career'])) {
            $edu = is_string($m['education_and_career'])
                ? (json_decode($m['education_and_career'], true)[0] ?? [])
                : ($m['education_and_career'][0] ?? []);
        }

        $astro = [];
        if (!empty($m['astronomic_information'])) {
            $astro = is_string($m['astronomic_information'])
                ? (json_decode($m['astronomic_information'], true)[0] ?? [])
                : ($m['astronomic_information'][0] ?? []);
        }
        $bas = [];
        if (!empty($m['basic_info'])) {
            $bas = is_string($m['basic_info'])
                ? (json_decode($m['basic_info'], true)[0] ?? [])
                : ($m['basic_info'][0] ?? []);
        }


        DB::table('profiles')->updateOrInsert(
            ['user_id' => $userId],
            [
                /* BASIC */
                'gender' => ($m['gender'] ?? '1') == '1' ? 'male' : 'female',
                'dob' => optional($dob)->format('Y-m-d'),
                'age' => optional($dob)->age,
                'marital_status' => $bas['marital_status'] ?? null,
                'registration_mode' => 'online',
                'membership_type' => 'default',
                'mobile' => $m['mobile'] ?? null,

                /* ADDRESS */
                'country' => $addr['country'] ?? null,
                'state' => $addr['state'] ?? null,
                'city' => $addr['city'] ?? null,
                'address' => $addr['address'] ?? null,
                'postal_code' => $addr['postal_code'] ?? null,

                /* PHYSICAL */
                'height' => isset($m['height']) ? (int) $m['height'] : null,

                /* EDUCATION & CAREER */
                'education' => $edu['Type_of_study'] ?? null,
                'occupation' => $edu['Type_of_occupation'] ?? null,
                'study_details' => $edu['STUDY_DETAILS'] ?? null,
                'career_profile' => $edu['Career_Profile'] ?? null,
                'earnings' => strtolower($edu['Earnings'] ?? null),
                'income_amount' => $this->cleanIncome($edu['annual_income'] ?? null),

                /* ASTRONOMIC */
                'day_of_birth' => $astro['birthDay'] ?? null,
                'birth_time' => $astro['time_of_birth'] ?? null,
                'paksha' => $astro['PAKSHA'] ?? null,
                'star' => $astro['star'] ?? null,
                'rasi' => $astro['rashi'] ?? null,
                'padam' => $astro['PADAM'] ?? null,
                'lakknam' => $astro['LAKKNAM'] ?? null,
                'horoscope_matching' => $astro['HOROSCOPE_MATCHING'] ?? null,
                'dosham' => $astro['DOSHAM'] ?? null,
                'tithi' => $astro['TITHI'] ?? null,
                'directional_balance' => $astro['DIRECTIONAL_BALANCE'] ?? null,
                'birth_city' => trim(
                    $astro['city_of_birth']
                    ?? $astro['birth_city']
                    ?? null
                ),


                /* META */
                'created_at' => $this->cleanDate($m['created_date']) ?? now(),
                'updated_at' => now(),
            ]
        );


        $profileId = DB::table('profiles')->where('user_id', $userId)->value('id');

        /* ================= ADDRESS ================= */
        $addr = json_decode($m['present_address'] ?? '[]', true)[0] ?? null;
        if ($addr) {
            DB::table('addresses')->updateOrInsert(
                ['profile_id' => $profileId],
                [
                    'country' => $addr['country'] ?? null,
                    'state' => $addr['state'] ?? null,
                    'city' => $addr['city'] ?? null,
                    'address' => $addr['address'] ?? null,
                    'postal_code' => $addr['postal_code'] ?? null,
                    'mobile' => $m['mobile'] ?? null,
                    'updated_at' => now(),
                ]
            );
        }
        /* ================= PHYSICAL ATTRIBUTES ================= */

        $physical_attributes = json_decode($m['physical_attributes'] ?? '[]', true)[0] ?? null;
        if ($physical_attributes) {
            DB::table('physical_attributes')->updateOrInsert(
                ['profile_id' => $profileId],
                [
                    'complexion' => $physical_attributes['complexion'] ?? null,
                    'body_type' => $physical_attributes['body_type'] ?? null,
                    'weight' => isset($physical_attributes['weight']) ? (int) $physical_attributes['weight'] : null,
                    'eye_color' => $physical_attributes['eye_color'] ?? null,
                    'height' => isset($m['height']) ? (int) $m['height'] : null,
                    'hair_color' => $physical_attributes['hair_color'] ?? null,
                    'physical_status' => $physical_attributes['any_disability'] ?? null,
                    'blood_group' => $physical_attributes['blood_group'] ?? null,
                    'updated_at' => now(),
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
                        'created_at' => $this->cleanDate($m['created_date']) ?? now(),
                        'updated_at' => now(),
                    ]
                );
            }


            /* ================= FAMILY ================= */

            $fam = json_decode($m['family_info'] ?? '[]', true)[0] ?? null;
            $spiritual = json_decode($m['spiritual_and_social_background'] ?? '[]', true)[0] ?? null;


            if ($fam) {
                DB::table('family_details')->updateOrInsert(
                    ['profile_id' => $profileId],
                    [
                        'surname' => $fam['surname'] ?? $fam['Surname'] ?? null,
                        'father_name' => $fam['father'] ?? null,
                        'mother_name' => $fam['mother'] ?? null,
                        'father_vangusam' => $fam['father_vangusam'] ?? null,
                        'mother_vangusam' => $fam['mother_vangusam'] ?? null,

                        'brothers_count' =>
                            $this->normalizeCount($fam['Number_of_brothers'] ?? null),

                        'brothers_married' =>
                            $this->normalizeCount($fam['Number_of_married_brothers'] ?? null),

                        'sisters_count' =>
                            $this->normalizeCount($fam['Number_of_Sisters'] ?? null),

                        'sisters_married' =>
                            $this->normalizeCount($fam['Number_of_married_sisters'] ?? null),

                        'family_type' => $fam['family_type'] ?? null,
                        'property_description' => $fam['property_description']
                            ?? $fam['Property_Description']
                            ?? null,

                        // optional / not in JSON
                        'soveran_details' => $m['soveran_detail'] ?? null,
                        'family_status' => $spiritual['family_status'] ?? null,
                        'family_values' => $spiritual['family_values'] ?? null,
                        'about_family' => $spiritual['about_family'] ?? null,

                        'updated_at' => now(),
                        'created_at' => now(),
                    ]
                );
            }

            /* ================= PARTNER (100% FINAL FIX) ================= */

            $preferredAgeMin = null;
            $preferredAgeMax = null;
            $preferredHeightMin = null;
            $preferredHeightMax = null;

            // 🔥 DEEP DECODE
            $decoded = $this->deepJsonDecode($m['partner_expectation'] ?? null);

            // Expect array like [ { partner_age: "20 to 30" } ]
            if (is_array($decoded) && isset($decoded[0])) {

                $ageText =
                    $decoded[0]['partner_age']
                    ?? $decoded[0]['Partner_Age']
                    ?? null;

                $heightText =
                    $decoded[0]['partner_height']
                    ?? $decoded[0]['Partner_Height']
                    ?? null;


                if ($ageText) {

                    $txt = strtolower(trim($ageText));

                    if (strpos($txt, 'to') !== false) {
                        [$a, $b] = explode('to', $txt);
                        $preferredAgeMin = (int) trim($a);
                        $preferredAgeMax = (int) trim($b);
                    } elseif (strpos($txt, '-') !== false) {
                        [$a, $b] = explode('-', $txt);
                        $preferredAgeMin = (int) trim($a);
                        $preferredAgeMax = (int) trim($b);
                    } elseif (is_numeric($txt)) {
                        $preferredAgeMin = (int) $txt;
                        $preferredAgeMax = (int) $txt;
                    }
                }

                if ($heightText) {

                    $txt = strtolower(trim($heightText));

                    if (strpos($txt, 'to') !== false) {
                        [$a, $b] = explode('to', $txt);
                        $preferredHeightMin = (int) trim($a);
                        $preferredHeightMax = (int) trim($b);
                    } elseif (strpos($txt, '-') !== false) {
                        [$a, $b] = explode('-', $txt);
                        $preferredHeightMin = (int) trim($a);
                        $preferredHeightMax = (int) trim($b);
                    } elseif (is_numeric($txt)) {
                        $preferredHeightMin = (int) $txt;
                        $preferredHeightMax = (int) $txt;
                    }
                }
            }

            // 🔥 FORCE SAVE
            DB::table('partner_preferences')->updateOrInsert(
                ['profile_id' => $profileId],
                [
                    'preferred_age_min' => $preferredAgeMin,
                    'preferred_age_max' => $preferredAgeMax,
                    'preferred_height_min' => $preferredHeightMin,
                    'preferred_height_max' => $preferredHeightMax,
                    'marital_status' => $bas['marital_status'] ?? null,
                    'education' => $edu['Type_of_study'] ?? null,
                    'religion' => $spiritual['religion'] ?? null,
                    'family_type' => $family['family_type'] ?? null,
                    'caste' => $spiritual['caste'] ?? null,
                    'height' => isset($m['height']) ? (int) $m['height'] : null,
                    'occupation' => $edu['Type_of_occupation'] ?? null,
                    'dosham' => $partner['Other_Dosham'] ?? null,
                    'horoscope_required' =>
                        (($partner['horoscope_required'] ?? '') === 'yes') ? true : false,
                    'updated_at' => now(),
                ]
            );


            /* ================= ASTRONOMIC ================= */
            $astro = json_decode($m['astronomic_information'] ?? '[]', true)[0] ?? null;
            $addr = json_decode($m['present_address'] ?? '[]', true)[0] ?? null;
            if ($astro) {
                DB::table('astronomic_information')->updateOrInsert(
                    ['profile_id' => $profileId],
                    [
                        'star' => $astro['star'] ?? null,
                        'rasi' => $astro['rashi'] ?? null,
                        'padam' => $astro['PADAM'] ?? null,
                        'dosham' => $astro['DOSHAM'] ?? null,
                        'tithi' => $astro['TITHI'] ?? null,
                        'birth_country' => $addr['country'] ?? null,
                        'birth_state' => $addr['state'] ?? null,
                        'day_of_birth' => $astro['birthDay'] ?? null,
                        'birth_city' => trim(
                            $astro['city_of_birth']
                            ?? $astro['birth_city']
                            ?? null
                        ),
                        'horoscope_matching' => $astro['HOROSCOPE_MATCHING'] ?? null,
                        'charan' => $astro['charan'] ?? null,
                        'ganam' => $astro['ganam'] ?? null,
                        'lakknam' => $astro['LAKKNAM'] ?? null,
                        'birth_time' => $astro['time_of_birth'] ?? null,
                        'birth_place' => $astro['city_of_birth'] ?? null,
                        'directional_balance' => $astro['DIRECTIONAL_BALANCE'] ?? null,
                        'created_at' => $this->cleanDate($m['created_date']) ?? now(),
                        'updated_at' => now(),
                    ]
                );
            }

            DB::table('members')->updateOrInsert(
                ['profile_id' => $profileId],
                [
                    'membership_id' => 1,

                    'start_date' => $this->cleanDate($m['membership_date'] ?? null),
                    'end_date' => $this->cleanDate($m['membership_date'] ?? null)->addYear(),

                    // limits
                    'sent_interest_allowed' => 0,
                    'profiles_view_allowed' => 0,
                    'messages_sent_allowed' => 0,
                    'sent_interest_remaining' => 0,
                    'profiles_view_remaining' => 0,
                    'messages_sent_remaining' => 0,

                    // 🔥 ALWAYS INACTIVE (because deactivated)
                    'status' => 'inactive',

                    'is_verified' => ($m['email_verification_status'] ?? 0) == 1,
                    'verified_by_admin' => ($m['status'] ?? '') === 'approved',
                    'blocked_by_admin' => ($m['is_blocked'] ?? 'no') === 'yes',

                    'is_reported' => !empty($m['reported_by']),
                    'is_matched' => !empty($m['matched_date']),

                    'membership_expired' => false,
                    'send_reminder' => false,
                    'auto_renewal' => false,

                    'is_deactivated' => true,
                    'member_no' => $m['member_profile_id'] ?? null,
                    'old_member_id' => $m['member_id'] ?? null,

                    'created_at' => $this->cleanDate($m['member_since'] ?? null),
                    'updated_at' => now(),
                ]
            );
        }

    }
}