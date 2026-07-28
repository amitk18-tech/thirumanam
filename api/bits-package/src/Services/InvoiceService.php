<?php

namespace Bits\Package\Services;

use Bits\Package\Repositories\InvoiceRepository;
use Bits\Package\Repositories\InvoiceSettingRepository;
use Illuminate\Support\Facades\DB;
use Exception;

class InvoiceService
{
    protected InvoiceRepository $invoiceRepo;
    protected InvoiceSettingRepository $settingRepo;

    public function __construct(InvoiceRepository $invoiceRepo, InvoiceSettingRepository $settingRepo)
    {
        $this->invoiceRepo = $invoiceRepo;
        $this->settingRepo = $settingRepo;
    }

    public function getAllInvoices(array $filters = [])
    {
        return $this->invoiceRepo->all($filters, [], ['items']);
    }

    public function getInvoice($id)
    {
        return $this->invoiceRepo->find($id, ['items']);
    }

    public function createInvoice(array $data)
    {
        return DB::transaction(function () use ($data) {
            $items = $data['items'] ?? [];
            $invoiceData = collect($data)->except('items')->toArray();

            // Calculate totals
            $totals = $this->calculateTotals($items, $invoiceData['discount_total'] ?? 0);
            $invoiceData = array_merge($invoiceData, $totals);

            // Auto-generate invoice number
            if (empty($invoiceData['invoice_no'])) {
                $invoiceData['invoice_no'] = 'INV-' . time();
            }

            // Populate Defaults from Settings
            $settings = $this->settingRepo->getSettings();
            if ($settings) {
                if (empty($invoiceData['bill_from'])) {
                    $invoiceData['bill_from'] = [
                        'name' => $settings->company_name,
                        'address' => $settings->address,
                        'phone' => $settings->phone,
                        'email' => $settings->email,
                        'tax_number' => $settings->tax_number
                    ];
                }
                if (empty($invoiceData['footer_text'])) {
                    $invoiceData['footer_text'] = $settings->default_footer_text ?? 'This is a computer generated invoice.';
                }
            } else {
                if (empty($invoiceData['footer_text'])) {
                    $invoiceData['footer_text'] = 'This is a computer generated invoice.';
                }
            }

            return $this->invoiceRepo->createWithItems($invoiceData, $items);
        });
    }

    public function updateInvoice($id, array $data)
    {
        return DB::transaction(function () use ($id, $data) {
            $items = $data['items'] ?? [];
            $invoiceData = collect($data)->except('items')->toArray();

            // Recalculate totals if items provided
            if (!empty($items)) {
                $totals = $this->calculateTotals($items, $invoiceData['discount_total'] ?? 0);
                $invoiceData = array_merge($invoiceData, $totals);
            }

            return $this->invoiceRepo->updateWithItems($id, $invoiceData, $items);
        });
    }

    public function deleteInvoice($id)
    {
        return $this->invoiceRepo->delete($id);
    }

    private function calculateTotals(array $items, $discountTotal = 0)
    {
        $subTotal = 0;
        $taxTotal = 0;

        foreach ($items as &$item) {
            $qty = $item['quantity'] ?? 0;
            $price = $item['unit_price'] ?? 0;
            $taxPercent = $item['tax_percent'] ?? 0;

            $lineTotal = $qty * $price;
            $taxAmount = $lineTotal * ($taxPercent / 100);

            $item['tax_amount'] = $taxAmount;
            $item['total'] = $lineTotal + $taxAmount;

            $subTotal += $lineTotal;
            $taxTotal += $taxAmount;
        }

        $grandTotal = $subTotal + $taxTotal - $discountTotal;

        return [
            'sub_total' => $subTotal,
            'tax_total' => $taxTotal,
            'grand_total' => $grandTotal,
            // 'discount_total' passed in or maintained
        ];
    }
}
