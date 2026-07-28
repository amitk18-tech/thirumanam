<!DOCTYPE html>
<html>

<head>
    <title>Purchase Order {{ $data['po_number'] ?? '' }}</title>

    <style>
    @php echo file_get_contents(public_path('css/bootstrap.min.css'));
    @endphp
    </style>

    <style>
    .container {
        width: 100%;
        max-width: 800px;
        margin: 0 auto;
    }

    .row {
        width: 100%;
        clear: both;
    }

    .col-left {
        float: left;
        width: 48%;
    }

    .col-right {
        float: right;
        width: 48%;
    }

    .text-primary {
        color: #337ab7;
    }

    body {
        font-family: Arial, sans-serif;
        font-size: 13px;
        color: #333;
    }

    .invoice-header {
        border-bottom: 2px solid #0d6efd;
        margin-bottom: 20px;
        padding-bottom: 10px;
    }

    .invoice-header h4 {
        margin: 0;
    }

    .details-section {
        margin-bottom: 25px;
    }

    .table th {
        background-color: #f1f3f5;
        text-transform: uppercase;
        font-size: 12px;
    }

    .table td,
    .table th {
        padding: 6px;
    }

    .footer {
        margin-top: 40px;
        font-size: 12px;
        text-align: center;
        color: #666;
        border-top: 1px solid #ccc;
        padding-top: 10px;
    }
    </style>
</head>

<body>
    {{-- Header --}}
    <div class="invoice-header d-flex justify-content-between align-items-center">
        <div>
            <img src="{{ public_path('images/logo.png') }}" alt="Logo" height="50">
        </div>

        @if(!empty($shop['shop_name']))
        <div>
            <strong>{{ $shop['shop_name'] ?? '' }}</strong><br>
            {{ $shop['shop_address'] ?? '' }}<br>
            {{ $shop['email'] ?? '' }}<br>
            {{ $shop['contact_number'] ?? '' }}<br>
            <strong>GST:</strong> {{ $shop['gst_number'] ?? '' }}
        </div>
        @endif

        <div class="text-end">
            <h4 class="text-primary">Purchase Order</h4>
            <small>#{{ $data['po_number'] ?? '' }}</small>
        </div>
    </div>

    {{-- Order & Supplier details in two columns --}}
    <div class="details-section">
        <div style="width:48%; float:left;">
            <h6 style="color:#0d6efd;">Order Details</h6>
            <p><strong>Date:</strong> {{ $data['order_date'] ?? '-' }}</p>
            <p><strong>Ordered Via:</strong> {{ $data['ordered_via'] ?? '-' }}</p>
            <p><strong>Order Taken By:</strong> {{ $data['order_taken_by'] ?? '-' }}</p>
            <p><strong>Expected Date:</strong> {{ $data['expected_date'] ?? '-' }}</p>
            <p><strong>Status:</strong> {{ $data['status'] ?? '-' }}</p>
            <p><strong>Notes:</strong> {{ $data['notes'] ?? 'N/A' }}</p>
        </div>

        <div style="width:48%; float:right;">
            <h6 style="color:#0d6efd;">Supplier Details</h6>
            <p><strong>Name:</strong> {{ $data['supplier']['name'] ?? '-' }}</p>
            <p><strong>Email:</strong> {{ $data['supplier']['email'] ?? '-' }}</p>
            <p><strong>Phone:</strong> {{ $data['supplier']['phone'] ?? '-' }}</p>
            <p><strong>GST:</strong> {{ $data['supplier']['gst'] ?? '-' }}</p>
            <p><strong>Address:</strong> {{ $data['supplier']['address'] ?? '-' }}</p>

        </div>

        <div style="clear:both;"></div>
    </div>

    {{-- Items Table --}}
    <h6 class="text-primary">Items</h6>
    <table class="table-bordered" style="width:100%; border-collapse: collapse; font-size: 12px;">
        <thead>
            <tr style="background-color: #e1effdff;">
                <th style="padding:3px;">Product</th>
                <th style=" padding:3px;">Brand</th>
                <th style=" padding:3px;">Strength</th>
                <th style=" padding:3px;">Manufacturer</th>
                <th style=" padding:3px;">HSN Code</th>
                <th style=" padding:3px;">Pack</th>
                <th style=" padding:3px;">Unit</th>
                <th style=" padding:3px;">Qty</th>
                <th style=" padding:3px;">Total Units</th>

            </tr>
        </thead>
        <tbody>
            @forelse($data['items'] ?? [] as $item)
            <tr style="background-color: <?php echo $loop->index % 2 == 0 ? '#ffffff' : '#f0f0f0ff'; ?>;">
                <td style=" padding:2px;">{{ $item['product']['display_name'] ?? '-' }}</td>
                <td style=" padding:2px;">{{ $item['product']['brand_name'] ?? '-' }}</td>
                <td style=" padding:2px;">{{ $item['product']['strength'] ?? '-' }}</td>
                <td style=" padding:2px;">{{ $item['product']['manufacturer'] ?? '-' }}</td>
                <td style=" padding:2px;">{{ $item['product']['hsn_code'] ?? '-' }}</td>
                <td style=" padding:2px;">
                    {{ ($item['pack_type'] ?? '-') . ' ' . ($item['product']['pack_size'] ?? '-') }}
                </td>
                <td style=" padding:2px;">{{ $item['selected_unit'] ?? '-' }}</td>
                <td style=" padding:2px;">{{ $item['quantity'] ?? '-' }}</td>
                <td style=" padding:2px;">
                    {{ ($item['total_units'] ?? '-') . ' ' . ($item['product']['base_unit'] ?? '-') }}
                </td>

            </tr>
            @empty
            <tr>
                <td colspan="11" style="text-align:center; color:#999; padding:3px;">No items found</td>
            </tr>
            @endforelse
        </tbody>
    </table>


    {{-- Footer --}}
    <div class="footer">
        <p><strong>Thank you for your business!</strong></p>
        <div class="alert alert-warning" role="alert">
            This is a computer-generated document. No signature is required.
        </div>
    </div>
</body>

</html>