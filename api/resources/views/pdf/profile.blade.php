<!DOCTYPE html>
<html lang="ta">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style>
    @font-face {
        font-family: 'tamilfont';
        src: url("{{ str_replace('\\', '/', storage_path('fonts/NotoSansTamil-Regular.ttf')) }}") format("truetype");
        font-weight: normal;
        font-style: normal;
    }

    * {
        box-sizing: border-box;
    }

    html,
    body {
        color: #000;
        font-size: 14px;
        font-family: 'tamilfont', 'DejaVu Sans', sans-serif !important;
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
    }

    @page {
        size: A4;
        margin: 8mm;
    }

    .print-wrapper {
        position: relative;
        font-family: 'tamilfont', 'DejaVu Sans', sans-serif !important;
    }

    .watermark {
        position: fixed;
        top: 50%;
        left: 50%;
        width: 520px;
        height: 520px;
        transform: translate(-50%, -50%) rotate(-45deg);
        opacity: 0.05;
        z-index: 0;
        pointer-events: none;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
    }

    .watermark img {
        width: 175px;
        margin-bottom: 10px;
    }

    .watermark-text {
        font-size: 48px;
        font-weight: 700;
        color: #000;
        letter-spacing: 2px;
    }

    .print-wrapper>*:not(.watermark) {
        position: relative;
        z-index: 1;
    }

    .clearfix::after {
        content: "";
        display: block;
        clear: both;
    }

    .left {
        float: left;
    }

    .right {
        float: right;
    }

    .page-meta {
        width: 100%;
        font-size: 11px;
        text-align: center;
        margin-bottom: 2px;
        position: relative;
        min-height: 16px;
    }

    .page-meta-left {
        position: absolute;
        left: 0;
        top: 0;
        white-space: nowrap;
    }

    .page-meta-center {
        display: inline-block;
        font-weight: 600;
    }

    .page-meta-eye {
        text-align: center;
        font-size: 11px;
        line-height: 1;
        margin-bottom: 4px;
    }

    .om-title {
        text-align: center;
        font-size: 24px;
        line-height: 1.1;
        margin: 3px 0 8px;
        font-weight: 500;
    }

    .header-top {
        border: 1px solid #000;
        margin-bottom: 0;
    }

    .logo-box {
        width: 80px;
        text-align: center;
    }

    .logo-box img {
        width: 56px;
        height: auto;
        margin-top: 4px;
    }

    .header-text {
        margin-left: 88px;
        text-align: center;
        line-height: 1.25;
    }

    .header-text .title {
        font-size: 16px;
        margin: 0;
        font-weight: 700;
        text-transform: uppercase;
    }

    .header-text .line {
        font-size: 11px;
        margin: 1px 0;
    }

    .service-row {
        margin-top: 0;
        border-left: 1px solid #000;
        border-right: 1px solid #000;
        border-bottom: 1px solid #000;
        padding: 0;
    }

    .service-left {
        float: left;
        width: 74%;
        font-size: 11px;
        line-height: 1.35;
        padding: 5px 8px;
    }

    .service-right {
        float: right;
        width: 26%;
        border-left: 1px solid #000;
        text-align: center;
    }

    .member-id {
        border-bottom: 1px solid #000;
        padding: 5px 4px;
        font-size: 11px;
    }

    .registered-date {
        padding: 6px 4px;
        font-size: 11px;
    }

    .contact-line {
        font-size: 10px;
        margin: 4px 0 6px;
    }

    .black-title {
        background: #000;
        color: #fff;
        text-align: center;
        font-weight: 700;
        font-size: 12px;
        line-height: 1.2;
        padding: 3px 6px;
        margin-top: 6px;
    }

    .two-col {
        width: 100%;
    }

    .col-50 {
        float: left;
        width: 50%;
    }

    table {
        border-collapse: collapse;
        width: 100%;
        table-layout: auto;
    }

    /* Standard row with label and value */
    table tr {
        border-bottom: 1px solid #000;
        width: 100%;
    }

    .grid-table {
        border: 1px solid #000;
        border-top: 0;
    }

    .grid-table.right-half {
        border-left: 0;
    }

    .grid-table th,
    .grid-table td {
        border-top: 0;
        border-bottom: 0;
        padding: 2px 4px;
        font-size: 11px;
        line-height: 1.15;
        vertical-align: middle;
        text-align: left;
        width: auto;
    }

    .grid-table th {
        border-left: 0;
        border-right: 0;
        white-space: nowrap;
        font-weight: normal;
    }

    .grid-table td {
        border-right: 0;
        border-left: 0;
        font-weight: bold;
    }

    .photo-cell {
        text-align: left;
        padding: 4px;
    }

    .photo-cell img {
        width: 86px;
        height: 86px;
        border: 1px solid #999;
        object-fit: cover;
    }

    .single-table {
        border-top: 0;
    }

    .single-table th {
        width: 12%;
    }

    .single-table td {
        width: 88%;
    }

    .horoscope-container {
        margin-top: 10px;
        page-break-before: always;
    }

    .horoscope-header {
        border: 1px solid #000;
        padding: 6px 8px;
    }

    .horoscope-header .logo-box img {
        width: 50px;
    }

    .mini-member {
        width: 170px;
        border: 1px solid #000;
        text-align: center;
        padding: 4px;
        font-size: 11px;
        margin-top: 2px;
    }

    .zodiac-wrap {
        margin-top: 6px;
    }

    .horo-two-col {
        width: 100%;
        border-collapse: separate;
        border-spacing: 8px 0;
        table-layout: fixed;
    }

    .horo-side {
        width: 50%;
        vertical-align: top;
    }

    .zodiac-title {
        text-align: center;
        font-size: 16px;
        font-weight: 700;
        margin-bottom: 4px;
    }

    .horo-grid {
        width: 100%;
        table-layout: fixed;
        border-collapse: collapse;
    }

    .horo-grid td {
        border: 1px solid #000;
        height: 58px;
        padding: 2px 3px;
        vertical-align: middle;
        text-align: center;
    }

    .horo-center {
        background: #e9e7bb;
        font-size: 14px;
        font-weight: 700;
        letter-spacing: 0.2px;
    }

    .zodiac-val-row {
        width: 100%;
        text-align: center;
        line-height: 1.2;
        word-wrap: break-word;
    }

    .zodiac-val-item {
        font-size: 10px;
        line-height: 1.2;
        white-space: normal;
        text-align: center;
        margin: 0;
        padding: 0;
        display: inline;
    }

    .laknam-crossed {
        position: relative;
    }

    .laknam-crossed::before {
        content: "//";
        position: absolute;
        top: 2px;
        left: 4px;
        font-weight: 900;
        font-size: 13px;
        line-height: 1;
        pointer-events: none;
        color: #000;
        z-index: 10;
    }

    .declaration-box {
        margin-top: 8px;
    }

    .declaration-list {
        margin: 0;
        padding-left: 18px;
        list-style-type: disc;
    }

    .declaration-list li {
        text-align: justify;
        font-size: 11px;
        line-height: 1.35;
    }

    .footer-box {
        margin-top: 10px;
        border: 2px solid #000;
        padding: 8px;
    }

    .footer-logo {
        float: left;
        width: 11%;
        text-align: center;
        padding-top: 3px;
    }

    .footer-logo img {
        width: 32px;
        height: auto;
    }

    .footer-text {
        float: left;
        width: 89%;
        text-align: center;
    }

    .footer-title {
        margin: 0;
        font-size: 14px;
        font-weight: 700;
        text-transform: uppercase;
    }

    .footer-address {
        margin-top: 2px;
        font-size: 11px;
        line-height: 1.25;
        font-weight: 600;
    }

    .footer-note {
        margin-top: 3px;
        font-size: 12px;
        font-style: italic;
        font-weight: 700;
    }

    .ad-box {
        width: 100%;
        text-align: center;
    }

    .ad-box img {
        width: 100%;
        height: auto;
        display: block;
    }
    </style>
</head>

<body>
    @php
    $photoPath = $profile->profile_photo ? public_path('storage/' . $profile->profile_photo) : (($profile->gender ??
    'male') === 'female' ? $defaultFemale : $defaultMale);
    $regDate = !empty($member->created_at) ? \Carbon\Carbon::parse($member->created_at)->format('d-m-Y') : '-';
    $printDateTime = now()->format('n/j/y, h:i A');
    $translateFn = $translate ?? fn($k, $p = 'FORM.') => $k;
    $valOrDash = fn($v) => ($v === null || $v === '' || strtolower((string) $v) === 'null') ? '-' : $v;
    $getFilledValues = function ($box) {
    return array_filter($box, fn($v) => !empty($v));
    };
    $renderBoxValues = function ($box) use ($getFilledValues, $translateFn) {
    $filled = $getFilledValues($box);
    if (empty($filled)) {
    return '&nbsp;';
    }
    $parts = [];
    foreach ($filled as $val) {
    $parts[] = e($translateFn($val, ''));
    }
    return implode(' <span style="font-weight:700; margin:0 4px;">|</span> ', $parts);
    };
    $boxLaknamClass = fn($box) => $checkLaknam($box) ? 'laknam-crossed' : '';
    $zIndicesTop = [1, 2, 3, 4];
    $zIndicesMidL = [5, 7];
    $zIndicesMidR = [6, 8];
    $zIndicesBot = [9, 10, 11, 12];
    @endphp

    <div class="print-wrapper">
        <div class="watermark">
            <img src="{{ $logoPath }}" alt="logo" />
            <div class="watermark-text">www.thirumanam.info</div>
        </div>

        <!-- <div class="page-meta">
            <div class="page-meta-left">{{ $printDateTime }}</div>
            <div class="page-meta-center">Admin | Thirumanam Matrimony</div>
        </div> -->
        <div class="page-meta-eye">உ</div>
        <div class="om-title">Om Muruga</div>

        <div class="header-top clearfix">
            <div class=" logo-box left">
                <img src="{{ $logoPath }}" alt="God Image">
            </div>
            <div class="header-text">
                <p class="title">{{ $translateFn('TITLE', 'PRINT_HEADER.') }}</p>
                <p class="line">{{ $translateFn('MANAGED_BY', 'PRINT_HEADER.') }}</p>
                <p class="line">{{ $translateFn('INFO_CENTRE', 'PRINT_HEADER.') }}</p>
                <p class="line">{{ $translateFn('ADDRESS_1', 'PRINT_HEADER.') }}</p>
                <p class="line">{{ $translateFn('ADDRESS_2', 'PRINT_HEADER.') }}</p>
                <p class="line">{{ $translateFn('WEBSITE', 'PRINT_HEADER.') }}</p>
            </div>
        </div>

        <div class="service-row clearfix">
            <div class="service-left">
                {!! $translateFn('WORKING_DAYS', 'PRINT_SERVICE_INFO.') !!}<br>
                {!! $translateFn('GROUPS', 'PRINT_SERVICE_INFO.') !!}<br>
                {{ $translateFn('SERVICE_TIME', 'PRINT_SERVICE_INFO.') }}
            </div>
            <div class="service-right">
                <div class="member-id">{{ $translateFn('MEMBER_ID') }}: <b>{{ $member->member_no ?? '-' }}</b></div>
                <div class="registered-date">{{ $translateFn('REGISTERED_DATE', 'TABLE.') }}: <b>{{ $regDate }}</b></div>
            </div>
        </div>

        <div class="contact-line">{{ $translateFn('CONTACT_INFO', 'PRINT_SERVICE_INFO.') }}</div>

        <div class="black-title">{{ $translateFn('BRIDE_GROOM_DETAILS', 'FORM.') }}</div>
        <div class="two-col clearfix">
            <div class="col-50">
                <table class="grid-table">
                    <tr>
                        <td colspan="2" class="photo-cell"><img src="{{ $photoPath }}" alt="photo" /></td>
                    </tr>
                    <tr>
                        <th>{{ $translateFn('NAME', 'FORM.') }}:</th>
                        <td>{{ $valOrDash($user->name) }}</td>
                    </tr>
                    <tr>
                        <th>{{ $translateFn('HEIGHT', 'FORM.') }}:</th>
                        <td>{{ $valOrDash($profile->height) }}</td>
                    </tr>
                    <tr>
                        <th>{{ $translateFn('COMPLEXION', 'FORM.') }}:</th>
                        <td>{{ $valOrDash($profile->complexion) }}</td>
                    </tr>
                    <tr>
                        <th>{{ $translateFn('MARITAL_STATUS', 'FORM.') }}:</th>
                        <td>{{ $translateFn($profile->marital_status) }}</td>
                    </tr>
                    <tr>
                        <th>{{ $translateFn('EDUCATION', 'FORM.') }}:</th>
                        <td>{{ $valOrDash($profile->education) }}</td>
                    </tr>
                    <tr>
                        <th>{{ $translateFn('STUDY_DETAILS', 'FORM.') }}:</th>
                        <td>{{ $valOrDash($profile->study_details) }}</td>
                    </tr>
                    <tr>
                        <th>{{ $translateFn('OCCUPATION', 'FORM.') }}:</th>
                        <td>{{ $valOrDash($profile->occupation) }}</td>
                    </tr>
                    <tr>
                        <th>{{ $translateFn('INCOME', 'FORM.') }}:</th>
                        <td>{{ $valOrDash($profile->income) }}</td>
                    </tr>
                </table>
            </div>
            <div class="col-50">
                <table class="grid-table right-half">
                    <tr>
                        <th>{{ $translateFn('AGE', 'FORM.') }}:</th>
                        <td>{{ $valOrDash($profile->age) }}</td>
                    </tr>
                    <tr>
                        <th>{{ $translateFn('DATE_OF_BIRTH', 'FORM.') }}:</th>
                        <td>{{ $valOrDash($profile->date_of_birth) }}</td>
                    </tr>
                    <tr>
                        <th>{{ $translateFn('DAY_OF_BIRTH', 'FORM.') }}:</th>
                        <td>{{ $translateFn($profile->day_of_birth) }}</td>
                    </tr>
                    <tr>
                        <th>{{ $translateFn('BIRTH_TIME', 'FORM.') }}:</th>
                        <td>{{ $valOrDash($profile->birth_time) }}</td>
                    </tr>
                    <tr>
                        <th>{{ $translateFn('BIRTH_CITY', 'FORM.') }}:</th>
                        <td>{{ $valOrDash($profile->birth_city) }}</td>
                    </tr>
                    <tr>
                        <th>{{ $translateFn('PAKSHA', 'FORM.') }}:</th>
                        <td>{{ $translateFn($profile->paksha) }}</td>
                    </tr>
                    <tr>
                        <th>{{ $translateFn('TITHI', 'FORM.') }}:</th>
                        <td>{{ $translateFn($profile->tithi) }}</td>
                    </tr>
                    <tr>
                        <th>{{ $translateFn('STAR', 'FORM.') }}:</th>
                        <td>{{ $translateFn($profile->star) }}</td>
                    </tr>
                    <tr>
                        <th>{{ $translateFn('PADAM', 'FORM.') }}:</th>
                        <td>{{ $translateFn($profile->padam) }}</td>
                    </tr>
                    <tr>
                        <th>{{ $translateFn('LAKKNAM', 'FORM.') }}:</th>
                        <td>{{ $translateFn($profile->lakknam) }}</td>
                    </tr>
                    <tr>
                        <th>{{ $translateFn('RASI', 'FORM.') }}:</th>
                        <td>{{ $translateFn($profile->rasi) }}</td>
                    </tr>
                    <tr>
                        <th>{{ $translateFn('DOSHAM', 'FORM.') }}:</th>
                        <td>{{ $translateFn($profile->dosham) }} @if(!empty($profile->type_of_dosham) && $profile->type_of_dosham !== '-' && strtolower($profile->dosham) !== 'no' && strtolower($profile->dosham) !== 'not applicable')({{ $translateFn($profile->type_of_dosham, 'FORM.') }})@endif</td>
                    </tr>
                    <tr>
                        <th>{{ $translateFn('DIRECTIONAL_BALANCE', 'FORM.') }}:</th>
                        <td>{{ $translateFn($profile->directional_balance) }} ({{ $profile->year }} {{ $translateFn('YEAR', 'FORM.') }} /
                            {{ $profile->month }} {{ $translateFn('MONTH', 'FORM.') }} / {{ $profile->day }} {{ $translateFn('DAY', 'FORM.') }})
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="black-title">{{ $translateFn('FAMILY_DETAILS', 'FORM.') }}</div>
        <div class="two-col clearfix">
            <div class="col-50">
                <table class="grid-table">
                    <tr>
                        <th>{{ $translateFn('SURNAME', 'FORM.') }}:</th>
                        <td>{{ $valOrDash($family->surname) }}</td>
                    </tr>
                    <tr>
                        <th>{{ $translateFn('FATHER_NAME', 'FORM.') }}:</th>
                        <td>{{ $valOrDash($family->father_name) }}</td>
                    </tr>
                    <tr>
                        <th>{{ $translateFn('MOTHER_NAME', 'FORM.') }}:</th>
                        <td>{{ $valOrDash($family->mother_name) }}</td>
                    </tr>
                    <tr>
                        <th>{{ $translateFn('BROTHERS_COUNT', 'FORM.') }}:</th>
                        <td>{{ $valOrDash($family->brothers_count) }}</td>
                    </tr>
                    <tr>
                        <th>{{ $translateFn('SISTERS_COUNT', 'FORM.') }}:</th>
                        <td>{{ $valOrDash($family->sisters_count) }}</td>
                    </tr>
                    <tr>
                        <th>{{ $translateFn('PROPERTY_DESCRIPTION', 'FORM.') }}:</th>
                        <td>{{ $valOrDash($family->property_description) }}</td>
                    </tr>
                </table>
            </div>
            <div class="col-50">
                <table class="grid-table right-half">
                    <tr>
                        <th>{{ $translateFn('EXPECTATIONS', 'FORM.') }}:</th>
                        <td>{{ $valOrDash($partner->about_partner) }}</td>
                    </tr>
                    <tr>
                        <th>{{ $translateFn('FATHER_VANGUSAM', 'FORM.') }}:</th>
                        <td>{{ $translateFn($family->father_vangusam, 'VANGUSAM.') }}</td>
                    </tr>
                    <tr>
                        <th>{{ $translateFn('MOTHER_VANGUSAM', 'FORM.') }}:</th>
                        <td>{{ $translateFn($family->mother_vangusam, 'VANGUSAM.') }}</td>
                    </tr>
                    <tr>
                        <th>{{ $translateFn('BROTHERS_MARRIED', 'FORM.') }}:</th>
                        <td>{{ $valOrDash($family->married_brothers) }}</td>
                    </tr>
                    <tr>
                        <th>{{ $translateFn('SISTERS_MARRIED', 'FORM.') }}:</th>
                        <td>{{ $valOrDash($family->married_sisters) }}</td>
                    </tr>
                    <tr>
                        <th>{{ $translateFn('SOVERAN_DETAILS', 'FORM.') }}:</th>
                        <td>{{ $valOrDash($family->soveran_details) }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="black-title">{{ $translateFn('ADDRESS_CONTACT', 'FORM.') }}</div>
        <table class="grid-table single-table">
            <tr>
                <th>{{ $translateFn('ADDRESS', 'FORM.') }}:</th>
                <td>{{ $profile->address ?? '-' }}, {{ $profile->city ?? '-' }},
                    {{ $translateFn($profile->state) }},
                    {{ $profile->country ?? '-' }} - {{ $profile->postal_code ?? '-' }}
                </td>
            </tr>
            <tr>
                <th style="text-align: left;">{{ $translateFn('PHONE', 'FORM.') }}:</th>
                <td style="text-align: left;">{{ $user->phone }}@if(!empty($profile->alternate_number) && $profile->alternate_number !== '-') , {{ $profile->alternate_number }}@endif</td>
            </tr>
        </table>

        <div class="horoscope-container">
            <div class="page-meta">
                <div class="page-meta-left">{{ $printDateTime }}</div>
                <div class="page-meta-center">Admin | {{ $translateFn('TITLE', 'PRINT_HEADER.') }}</div>
            </div>

            <div class="horoscope-header clearfix">
                <div class="logo-box left">
                    <img src="{{ $logoPath }}" alt="God Image">
                </div>
                <div class="header-text">
                    <p class="title">{{ $translateFn('TITLE', 'PRINT_HEADER.') }}</p>
                    <p class="line">{{ $translateFn('MANAGED_BY', 'PRINT_HEADER.') }}</p>
                    <p class="line">{{ $translateFn('INFO_CENTRE', 'PRINT_HEADER.') }}</p>
                    <p class="line">{{ $translateFn('ADDRESS_1', 'PRINT_HEADER.') }}</p>
                    <p class="line">{{ $translateFn('ADDRESS_2', 'PRINT_HEADER.') }}</p>
                    <p class="line">{{ $translateFn('WEBSITE', 'PRINT_HEADER.') }}</p>
                </div>
            </div>

            <div class="clearfix" style="margin-top:4px;">
                <div class="right mini-member">{{ $translateFn('MEMBER_ID') }}: <b>{{ $member->member_no ?? '-' }}</b></div>
            </div>

            <div class="zodiac-wrap clearfix">
                <table class="horo-two-col">
                    <tr>
                        <td class="horo-side">
                            <!-- <div class="zodiac-title">Zodiac</div> -->
                            <table class="horo-grid">
                                <tr>
                                    <td class="{{ $boxLaknamClass($zodiacBoxes[0]) }}">
                                        <div class="zodiac-val-row">{!! $renderBoxValues($zodiacBoxes[0]) !!}</div>
                                    </td>
                                    <td class="{{ $boxLaknamClass($zodiacBoxes[1]) }}">
                                        <div class="zodiac-val-row">{!! $renderBoxValues($zodiacBoxes[1]) !!}</div>
                                    </td>
                                    <td class="{{ $boxLaknamClass($zodiacBoxes[2]) }}">
                                        <div class="zodiac-val-row">{!! $renderBoxValues($zodiacBoxes[2]) !!}</div>
                                    </td>
                                    <td class="{{ $boxLaknamClass($zodiacBoxes[3]) }}">
                                        <div class="zodiac-val-row">{!! $renderBoxValues($zodiacBoxes[3]) !!}</div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="{{ $boxLaknamClass($zodiacBoxes[4]) }}">
                                        <div class="zodiac-val-row">{!! $renderBoxValues($zodiacBoxes[4]) !!}</div>
                                    </td>
                                    <td class="horo-center" colspan="2" rowspan="2">{{ $translateFn('ZODIAC', '') }}</td>
                                    <td class="{{ $boxLaknamClass($zodiacBoxes[5]) }}">
                                        <div class="zodiac-val-row">{!! $renderBoxValues($zodiacBoxes[5]) !!}</div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="{{ $boxLaknamClass($zodiacBoxes[6]) }}">
                                        <div class="zodiac-val-row">{!! $renderBoxValues($zodiacBoxes[6]) !!}</div>
                                    </td>
                                    <td class="{{ $boxLaknamClass($zodiacBoxes[7]) }}">
                                        <div class="zodiac-val-row">{!! $renderBoxValues($zodiacBoxes[7]) !!}</div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="{{ $boxLaknamClass($zodiacBoxes[8]) }}">
                                        <div class="zodiac-val-row">{!! $renderBoxValues($zodiacBoxes[8]) !!}</div>
                                    </td>
                                    <td class="{{ $boxLaknamClass($zodiacBoxes[9]) }}">
                                        <div class="zodiac-val-row">{!! $renderBoxValues($zodiacBoxes[9]) !!}</div>
                                    </td>
                                    <td class="{{ $boxLaknamClass($zodiacBoxes[10]) }}">
                                        <div class="zodiac-val-row">{!! $renderBoxValues($zodiacBoxes[10]) !!}</div>
                                    </td>
                                    <td class="{{ $boxLaknamClass($zodiacBoxes[11]) }}">
                                        <div class="zodiac-val-row">{!! $renderBoxValues($zodiacBoxes[11]) !!}</div>
                                    </td>
                                </tr>
                            </table>
                        </td>

                        <td class="horo-side">
                            <!-- <div class="zodiac-title">Feature</div> -->
                            <table class="horo-grid">
                                <tr>
                                    <td class="{{ $boxLaknamClass($featureBoxes[0]) }}">
                                        <div class="zodiac-val-row">{!! $renderBoxValues($featureBoxes[0]) !!}</div>
                                    </td>
                                    <td class="{{ $boxLaknamClass($featureBoxes[1]) }}">
                                        <div class="zodiac-val-row">{!! $renderBoxValues($featureBoxes[1]) !!}</div>
                                    </td>
                                    <td class="{{ $boxLaknamClass($featureBoxes[2]) }}">
                                        <div class="zodiac-val-row">{!! $renderBoxValues($featureBoxes[2]) !!}</div>
                                    </td>
                                    <td class="{{ $boxLaknamClass($featureBoxes[3]) }}">
                                        <div class="zodiac-val-row">{!! $renderBoxValues($featureBoxes[3]) !!}</div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="{{ $boxLaknamClass($featureBoxes[4]) }}">
                                        <div class="zodiac-val-row">{!! $renderBoxValues($featureBoxes[4]) !!}</div>
                                    </td>
                                    <td class="horo-center" colspan="2" rowspan="2">{{ $translateFn('FEATURE', '') }}</td>
                                    <td class="{{ $boxLaknamClass($featureBoxes[5]) }}">
                                        <div class="zodiac-val-row">{!! $renderBoxValues($featureBoxes[5]) !!}</div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="{{ $boxLaknamClass($featureBoxes[6]) }}">
                                        <div class="zodiac-val-row">{!! $renderBoxValues($featureBoxes[6]) !!}</div>
                                    </td>
                                    <td class="{{ $boxLaknamClass($featureBoxes[7]) }}">
                                        <div class="zodiac-val-row">{!! $renderBoxValues($featureBoxes[7]) !!}</div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="{{ $boxLaknamClass($featureBoxes[8]) }}">
                                        <div class="zodiac-val-row">{!! $renderBoxValues($featureBoxes[8]) !!}</div>
                                    </td>
                                    <td class="{{ $boxLaknamClass($featureBoxes[9]) }}">
                                        <div class="zodiac-val-row">{!! $renderBoxValues($featureBoxes[9]) !!}</div>
                                    </td>
                                    <td class="{{ $boxLaknamClass($featureBoxes[10]) }}">
                                        <div class="zodiac-val-row">{!! $renderBoxValues($featureBoxes[10]) !!}
                                        </div>
                                    </td>
                                    <td class="{{ $boxLaknamClass($featureBoxes[11]) }}">
                                        <div class="zodiac-val-row">{!! $renderBoxValues($featureBoxes[11]) !!}
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </div>

            <div class="declaration-box">
                <ul class="declaration-list">
                    <li>{{ $translateFn('POINT_1', 'PRINT_DECLARATION.') }}</li>
                    <li>{{ $translateFn('POINT_2', 'PRINT_DECLARATION.') }}</li>
                    <li>{{ $translateFn('POINT_3', 'PRINT_DECLARATION.') }}</li>
                    <li>{{ $translateFn('POINT_4', 'PRINT_DECLARATION.') }}</li>
                    <li>{{ $translateFn('POINT_5', 'PRINT_DECLARATION.') }}</li>
                    <li>{{ $translateFn('POINT_6', 'PRINT_DECLARATION.') }}</li>
                    <li>{{ $translateFn('POINT_7', 'PRINT_DECLARATION.') }}</li>
                    <li>{{ $translateFn('POINT_8', 'PRINT_DECLARATION.') }}</li>
                    <li>{{ $translateFn('POINT_9', 'PRINT_DECLARATION.') }}</li>
                </ul>
            </div>

            <div class="footer-box clearfix">
                <div class="footer-logo">
                    <img src="{{ $acsLogoPath }}" alt="Logo">
                </div>
                <div class="footer-text">
                    <p class="footer-title">{{ $translateFn('TITLE', 'PRINT_FOOTER.') }}</p>
                    <div class="footer-address">
                        {{ $translateFn('ADDRESS_1', 'PRINT_FOOTER.') }}<br>
                        {{ $translateFn('ADDRESS_2', 'PRINT_FOOTER.') }}
                    </div>
                    <div class="footer-note">{{ $translateFn('INFO', 'PRINT_FOOTER.') }}</div>
                </div>
            </div>

            <div class="ad-box">
                <img src="{{ $adPath }}" alt="Ad">
            </div>
        </div>
    </div>
</body>

</html>