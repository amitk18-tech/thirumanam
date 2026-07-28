<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceController extends Controller
{
    public function generatePdf()
    {
        // ---- Dummy invoice array ----
        $invoice = [
            'logo_url' => public_path('dummy-logo.png'),
            'date' => now()->format('d/m/Y'),
            'number' => 'INV-1001',

            'supplier' => [
                'name' => 'ABC Traders Pvt Ltd',
                'number' => 'SUP-9988',
                'vat' => 'GST1234',
                'address1' => '12, Main Road',
                'address2' => 'Chennai, TN',
                'country' => 'India',
                'email' => 'abc@example.com',
                'phone' => '+91 9090909090',
            ],

            'customer' => [
                'name' => 'John Doe Enterprises',
                'number' => 'CUST-5566',
                'vat' => 'GST2020',
                'address1' => 'Park Avenue',
                'address2' => 'Bangalore, KA',
                'country' => 'India',
            ],

            'items' => [
                [
                    'name' => 'Laptop HP 15s',
                    'price' => 45000,
                    'qty' => 1,
                    'vat' => 18,
                    'subtotal' => 45000,
                    'total_with_vat' => 53100,
                ],
                [
                    'name' => 'Dell Mouse',
                    'price' => 500,
                    'qty' => 2,
                    'vat' => 18,
                    'subtotal' => 1000,
                    'total_with_vat' => 1180,
                ],
            ],

            'net_total' => 46000,
            'vat_total' => 9180,
            'grand_total' => 55180,

            'payment' => [
                'bank_name' => 'HDFC Bank',
                'sort_code' => 'HDFC0011',
                'account_number' => '1234567890',
            ],

            'notes' => 'Thanks for your business!',
        ];

        // PDF
        $pdf = Pdf::loadView('invoices.pdf', [
            'invoice' => (object) $invoice
        ]);

        return $pdf->download('dummy-invoice.pdf');
    }
}
