<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
    /* PRIMARY & SECONDARY COLOR CHANGES */
    .border-main {
        border-color: #1e3a8a;
        /* deep blue */
    }

    .bg-main {
        background-color: #1e3a8a;
        /* deep blue */
    }

    .text-main {
        color: #1e3a8a;
        /* deep blue */
    }

    .bg-slate-100 {
        background-color: #facc15;
        /* gold */
    }

    /* SHADES TWEAKED FOR THE THEME */
    .text-neutral-600 {
        color: #4b5563;
        /* darker gray */
    }

    .text-neutral-700 {
        color: #374151;
        /* even darker gray */
    }

    .text-slate-300 {
        color: #d1d5db;
    }

    .text-slate-400 {
        color: #9ca3af;
    }

    /* Everything else EXACTLY same as your original CSS */
    *,
    ::before,
    ::after {
        box-sizing: border-box;
        border-width: 0;
        border-style: solid;
        border-color: #e5e7eb;
    }

    ::before,
    ::after {
        --tw-content: '';
    }

    html {
        line-height: 1.5;
        -webkit-text-size-adjust: 100%;
        -moz-tab-size: 4;
        tab-size: 4;
        font-family: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont,
            "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif,
            "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
        font-feature-settings: normal;
        font-variation-settings: normal;
    }

    body {
        margin: 0;
        line-height: inherit;
    }

    hr {
        height: 0;
        color: inherit;
        border-top-width: 1px;
    }

    abbr:where([title]) {
        -webkit-text-decoration: underline dotted;
        text-decoration: underline dotted;
    }

    h1,
    h2,
    h3,
    h4,
    h5,
    h6 {
        font-size: inherit;
        font-weight: inherit;
    }

    a {
        color: inherit;
        text-decoration: inherit;
    }

    b,
    strong {
        font-weight: bolder;
    }

    code,
    kbd,
    samp,
    pre {
        font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas,
            "Liberation Mono", "Courier New", monospace;
        font-size: 1em;
    }

    small {
        font-size: 80%;
    }

    sub,
    sup {
        font-size: 75%;
        line-height: 0;
        position: relative;
        vertical-align: baseline;
    }

    sub {
        bottom: -0.25em;
    }

    sup {
        top: -0.5em;
    }

    table {
        text-indent: 0;
        border-color: inherit;
        border-collapse: collapse;
    }

    button,
    input,
    optgroup,
    select,
    textarea {
        font-family: inherit;
        font-feature-settings: inherit;
        font-variation-settings: inherit;
        font-size: 100%;
        font-weight: inherit;
        line-height: inherit;
        color: inherit;
        margin: 0;
        padding: 0;
    }

    button,
    select {
        text-transform: none;
    }

    button,
    [type='button'],
    [type='reset'],
    [type='submit'] {
        -webkit-appearance: button;
        background-color: transparent;
        background-image: none;
    }

    :-moz-focusring {
        outline: auto;
    }

    :-moz-ui-invalid {
        box-shadow: none;
    }

    progress {
        vertical-align: baseline;
    }

    ::-webkit-inner-spin-button,
    ::-webkit-outer-spin-button {
        height: auto;
    }

    [type='search'] {
        -webkit-appearance: textfield;
        outline-offset: -2px;
    }

    ::-webkit-search-decoration {
        -webkit-appearance: none;
    }

    ::-webkit-file-upload-button {
        -webkit-appearance: button;
        font: inherit;
    }

    summary {
        display: list-item;
    }

    blockquote,
    dl,
    dd,
    h1,
    h2,
    h3,
    h4,
    h5,
    h6,
    hr,
    figure,
    p,
    pre {
        margin: 0;
    }

    fieldset {
        margin: 0;
        padding: 0;
    }

    legend {
        padding: 0;
    }

    ol,
    ul,
    menu {
        list-style: none;
        margin: 0;
        padding: 0;
    }

    dialog {
        padding: 0;
    }

    textarea {
        resize: vertical;
    }

    input::placeholder,
    textarea::placeholder {
        opacity: 1;
        color: #9ca3af;
    }

    button,
    [role="button"] {
        cursor: pointer;
    }

    :disabled {
        cursor: default;
    }

    img,
    svg,
    video,
    canvas,
    audio,
    iframe,
    embed,
    object {
        display: block;
        vertical-align: middle;
    }

    img,
    video {
        max-width: 100%;
        height: auto;
    }

    [hidden] {
        display: none;
    }

    @page {
        margin: 0;
    }

    @media print {
        body {
            -webkit-print-color-adjust: exact;
        }
    }

    /* Utility Classes (unchanged) */
    .h-12 {
        height: 3rem;
    }

    .w-1\/2 {
        width: 50%;
    }

    .w-full {
        width: 100%;
    }

    .border-b {
        border-bottom-width: 1px;
    }

    .border-b-2 {
        border-bottom-width: 2px;
    }

    .border-r {
        border-right-width: 1px;
    }

    .p-3 {
        padding: .75rem;
    }

    .px-14 {
        padding-left: 3.5rem;
        padding-right: 3.5rem;
    }

    .px-2 {
        padding-left: .5rem;
        padding-right: .5rem;
    }

    .py-10 {
        padding-top: 2.5rem;
        padding-bottom: 2.5rem;
    }

    .py-3 {
        padding-top: .75rem;
        padding-bottom: .75rem;
    }

    .py-4 {
        padding-top: 1rem;
        padding-bottom: 1rem;
    }

    .py-6 {
        padding-top: 1.5rem;
        padding-bottom: 1.5rem;
    }

    .pb-3 {
        padding-bottom: .75rem;
    }

    .pl-2 {
        padding-left: .5rem;
    }

    .pl-3 {
        padding-left: .75rem;
    }

    .pl-4 {
        padding-left: 1rem;
    }

    .pr-3 {
        padding-right: .75rem;
    }

    .pr-4 {
        padding-right: 1rem;
    }

    .text-center {
        text-align: center;
    }

    .text-right {
        text-align: right;
    }

    .align-top {
        vertical-align: top;
    }

    .text-sm {
        font-size: .875rem;
        line-height: 1.25rem;
    }

    .text-xs {
        font-size: .75rem;
        line-height: 1rem;
    }

    .font-bold {
        font-weight: 700;
    }

    .italic {
        font-style: italic;
    }
    </style>
</head>

<body>
    <div>
        <div class="py-4">
            <div class="px-14 py-6">
                <table class="w-full border-collapse border-spacing-0">
                    <tbody>
                        <tr>
                            <td class="w-full align-top">
                                <div>
                                    <img src="{{ $invoice->logo_url }}" class="h-12" />
                                </div>
                            </td>

                            <td class="align-top">
                                <div class="text-sm">
                                    <table class="border-collapse border-spacing-0">
                                        <tbody>
                                            <tr>
                                                <td class="border-r pr-4">
                                                    <div>
                                                        <p class="whitespace-nowrap text-slate-400 text-right">Date</p>
                                                        <p class="whitespace-nowrap font-bold text-main text-right">
                                                            {{ $invoice->date }}
                                                        </p>
                                                    </div>
                                                </td>
                                                <td class="pl-4">
                                                    <div>
                                                        <p class="whitespace-nowrap text-slate-400 text-right">Invoice #
                                                        </p>
                                                        <p class="whitespace-nowrap font-bold text-main text-right">
                                                            {{ $invoice->number }}
                                                        </p>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="bg-slate-100 px-14 py-6 text-sm">
                <table class="w-full border-collapse border-spacing-0">
                    <tbody>
                        <tr>
                            <td class="w-1/2 align-top">
                                <div class="text-sm text-neutral-600">
                                    <p class="font-bold">{{ $invoice->supplier['name'] }}</p>
                                    <p>Number: {{ $invoice->supplier['number'] }}</p>
                                    <p>VAT: {{ $invoice->supplier['vat'] }}</p>
                                    <p>{{ $invoice->supplier['address1'] }}</p>
                                    <p>{{ $invoice->supplier['address2'] }}</p>
                                    <p>{{ $invoice->supplier['country'] }}</p>
                                </div>
                            </td>

                            <td class="w-1/2 align-top text-right">
                                <div class="text-sm text-neutral-600">
                                    <p class="font-bold">{{ $invoice->customer['name'] }}</p>
                                    <p>Number: {{ $invoice->customer['number'] }}</p>
                                    <p>VAT: {{ $invoice->customer['vat'] }}</p>
                                    <p>{{ $invoice->customer['address1'] }}</p>
                                    <p>{{ $invoice->customer['address2'] }}</p>
                                    <p>{{ $invoice->customer['country'] }}</p>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="px-14 py-10 text-sm text-neutral-700">
                <table class="w-full border-collapse border-spacing-0">
                    <thead>
                        <tr>
                            <td class="border-b-2 border-main pb-3 pl-3 font-bold text-main">#</td>
                            <td class="border-b-2 border-main pb-3 pl-2 font-bold text-main">Product details</td>
                            <td class="border-b-2 border-main pb-3 pl-2 text-right font-bold text-main">Price</td>
                            <td class="border-b-2 border-main pb-3 pl-2 text-center font-bold text-main">Qty.</td>
                            <td class="border-b-2 border-main pb-3 pl-2 text-center font-bold text-main">VAT</td>
                            <td class="border-b-2 border-main pb-3 pl-2 text-right font-bold text-main">Subtotal</td>
                            <td class="border-b-2 border-main pb-3 pl-2 pr-3 text-right font-bold text-main">Subtotal +
                                VAT</td>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($invoice->items as $index => $item)
                        <tr>
                            <td class="border-b py-3 pl-3">{{ $index + 1 }}.</td>
                            <td class="border-b py-3 pl-2">{{ $item['name'] }}</td>
                            <td class="border-b py-3 pl-2 text-right">{{ $item['price'] }}</td>
                            <td class="border-b py-3 pl-2 text-center">{{ $item['qty'] }}</td>
                            <td class="border-b py-3 pl-2 text-center">{{ $item['vat'] }}%</td>
                            <td class="border-b py-3 pl-2 text-right">{{ $item['subtotal'] }}</td>
                            <td class="border-b py-3 pl-2 pr-3 text-right">{{ $item['total_with_vat'] }}</td>
                        </tr>
                        @endforeach

                        <tr>
                            <td colspan="7">
                                <table class="w-full border-collapse border-spacing-0">
                                    <tbody>
                                        <tr>
                                            <td class="w-full"></td>
                                            <td>
                                                <table class="w-full border-collapse border-spacing-0">
                                                    <tbody>
                                                        <tr>
                                                            <td class="border-b p-3">
                                                                <div class="whitespace-nowrap text-slate-400">Net total:
                                                                </div>
                                                            </td>
                                                            <td class="border-b p-3 text-right">
                                                                <div class="whitespace-nowrap font-bold text-main">
                                                                    {{ $invoice->net_total }}
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="p-3">
                                                                <div class="whitespace-nowrap text-slate-400">VAT total:
                                                                </div>
                                                            </td>
                                                            <td class="p-3 text-right">
                                                                <div class="whitespace-nowrap font-bold text-main">
                                                                    {{ $invoice->vat_total }}
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="bg-main p-3">
                                                                <div class="whitespace-nowrap font-bold text-white">
                                                                    Total:</div>
                                                            </td>
                                                            <td class="bg-main p-3 text-right">
                                                                <div class="whitespace-nowrap font-bold text-white">
                                                                    {{ $invoice->grand_total }}
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>

            <div class="px-14 text-sm text-neutral-700">
                <p class="text-main font-bold">PAYMENT DETAILS</p>
                <p>{{ $invoice->payment['bank_name'] }}</p>
                <p>Bank/Sort Code: {{ $invoice->payment['sort_code'] }}</p>
                <p>Account Number: {{ $invoice->payment['account_number'] }}</p>
                <p>Payment Reference: {{ $invoice->number }}</p>
            </div>

            <div class="px-14 py-10 text-sm text-neutral-700">
                <p class="text-main font-bold">Notes</p>
                <p class="italic">{{ $invoice->notes }}</p>
            </div>

            <footer class="fixed bottom-0 left-0 bg-slate-100 w-full text-neutral-600 text-center text-xs py-3">
                {{ $invoice->supplier['name'] }}
                <span class="text-slate-300 px-2">|</span>
                {{ $invoice->supplier['email'] }}
                <span class="text-slate-300 px-2">|</span>
                {{ $invoice->supplier['phone'] }}
            </footer>
        </div>
    </div>

</body>

</html>