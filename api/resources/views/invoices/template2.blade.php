<!DOCTYPE html>
<html>

<head>
    <title>Invoice {{ $invoice->invoice_number }}</title>
    <style>
    body {
        font-family: "Times New Roman", serif;
        font-size: 14px;
        color: #333;
    }

    h2 {
        color: #007BFF;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
    }

    th,
    td {
        border: 1px solid #555;
        padding: 6px;
    }
    </style>
</head>

<body>
    <h2>Invoice: {{ $invoice->invoice_number }}</h2>
    <p><strong>Date:</strong> {{ $invoice->invoice_date }}</p>
    <p><strong>Customer:</strong> {{ $invoice->customer_name }}</p>

    <table>
        <thead>
            <tr>
                <th>Product</th>
                <th>Qty</th>
                <th>Rate</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach($invoice->items as $item)
            <tr>
                <td>{{ $item->name }}</td>
                <td>{{ $item->qty }}</td>
                <td>{{ $item->price }}</td>
                <td>{{ $item->total }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h3>Total: {{ $invoice->total_amount }}</h3>
</body>

</html>