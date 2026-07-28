<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Invoice #{{ $invoice->invoice_no }}</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 14px;
            line-height: 1.4;
            color: #333;
        }

        .container {
            width: 100%;
            margin: 0 auto;
        }

        .header {
            width: 100%;
            margin-bottom: 30px;
            border-bottom: 2px solid #eee;
            padding-bottom: 20px;
        }

        .company-info {
            float: left;
        }

        .invoice-info {
            float: right;
            text-align: right;
        }

        .clear {
            clear: both;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
        }

        .items-table th {
            background: #f8f8f8;
            text-align: left;
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }

        .items-table td {
            padding: 10px;
            border-bottom: 1px solid #eee;
        }

        .totals {
            margin-top: 30px;
            float: right;
            width: 300px;
        }

        .totals-row {
            display: flex;
            justify-content: space-between;
            padding: 5px 0;
        }

        .totals-row.grand-total {
            font-weight: bold;
            font-size: 16px;
            border-top: 1px solid #333;
            margin-top: 10px;
            padding-top: 10px;
        }

        .footer {
            margin-top: 50px;
            border-top: 1px solid #eee;
            padding-top: 20px;
            font-size: 12px;
            color: #777;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="header">
            <div class="company-info">
                {{-- Bill From (Snapshot) --}}
                @if(!empty($invoice->bill_from))
                    <strong>{{ $invoice->bill_from['name'] ?? '' }}</strong><br>
                    {{ $invoice->bill_from['address'] ?? '' }}<br>
                    @if(!empty($invoice->bill_from['phone'])) Phone: {{ $invoice->bill_from['phone'] }}<br> @endif
                    @if(!empty($invoice->bill_from['email'])) Email: {{ $invoice->bill_from['email'] }} @endif
                @else
                    <strong>Seller:</strong><br>
                    My Company LLC
                @endif
            </div>

            <div class="invoice-info">
                <h1>{{ strtoupper($invoice->invoice_type) }}</h1>
                <p>
                    <strong>Number:</strong> {{ $invoice->invoice_no }}<br>
                    <strong>Date:</strong> {{ $invoice->invoice_date->format('Y-m-d') }}<br>
                    @if($invoice->due_date)
                        <strong>Due Date:</strong> {{ $invoice->due_date->format('Y-m-d') }}<br>
                    @endif
                </p>
            </div>
            <div class="clear"></div>
        </div>

        <div class="customer-info">
            <strong>Bill To:</strong><br>
            @if(!empty($invoice->bill_to))
                {{ $invoice->bill_to['name'] ?? 'Customer' }}<br>
                {{ $invoice->bill_to['address'] ?? '' }}<br>
                {{ $invoice->bill_to['phone'] ?? '' }}
            @elseif(!empty($invoice->customer_details))
                {{ $invoice->customer_details['name'] ?? 'Customer' }}<br>
                {{ $invoice->customer_details['address'] ?? '' }}
            @else
                Customer ID: {{ $invoice->customer_id }}
            @endif
        </div>

        <table class="items-table">
            <thead>
                <tr>
                    <th>Item</th>
                    <th style="text-align: right;">Qty</th>
                    <th style="text-align: right;">Price</th>
                    <th style="text-align: right;">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($invoice->items as $item)
                    <tr>
                        <td>
                            <strong>{{ $item->item_name }}</strong><br>
                            <small>{{ $item->description }}</small>
                        </td>
                        <td style="text-align: right;">{{ $item->quantity + 0 }}</td>
                        <td style="text-align: right;">{{ number_format($item->unit_price, 2) }}</td>
                        <td style="text-align: right;">{{ number_format($item->total, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="totals">
            <div class="totals-row">
                <span>Subtotal:</span>
                <span>{{ $invoice->currency_code }} {{ number_format($invoice->sub_total, 2) }}</span>
            </div>
            @if($invoice->tax_total > 0)
                <div class="totals-row">
                    <span>Tax:</span>
                    <span>{{ $invoice->currency_code }} {{ number_format($invoice->tax_total, 2) }}</span>
                </div>
            @endif
            @if($invoice->discount_total > 0)
                <div class="totals-row">
                    <span>Discount:</span>
                    <span>- {{ $invoice->currency_code }} {{ number_format($invoice->discount_total, 2) }}</span>
                </div>
            @endif
            <div class="totals-row grand-total">
                <span>Total:</span>
                <span>{{ $invoice->currency_code }} {{ number_format($invoice->grand_total, 2) }}</span>
            </div>
        </div>
        <div class="clear"></div>

        <div class="footer">
            @if($invoice->notes)
                <p><strong>Notes:</strong><br>{{ $invoice->notes }}</p>
            @endif

            @if($invoice->terms)
                <p><strong>Terms:</strong><br>{{ $invoice->terms }}</p>
            @endif

            @if($invoice->footer_text)
                <p style="margin-top: 20px; text-align: center; font-style: italic;">
                    {{ $invoice->footer_text }}
                </p>
            @endif
        </div>
    </div>

</body>

</html>