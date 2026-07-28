<?php

namespace App\Repositories;

use App\Models\StockBatch;

class StockBatchQueryRepository
{
    protected int $tenantId;

    public function __construct(int $tenantId)
    {
        $this->tenantId = $tenantId;
    }

    public function list(array $filters = [])
    {
        $query = StockBatch::where('tenant_id', $this->tenantId);

        foreach ($filters as $key => $value) {
            $query->where($key, $value);
        }

        return $query->get();
    }

    public function hasSales(int $purchaseInvoiceItemId): bool
    {
        return StockBatch::where('tenant_id', $this->tenantId)
            ->where('purchase_invoice_item_id', $purchaseInvoiceItemId)
            ->where('sold_units', '>', 0)
            ->exists();
    }

    public function findByItemId(int $purchaseInvoiceItemId)
    {
        return StockBatch::where('tenant_id', $this->tenantId)
            ->where('purchase_invoice_item_id', $purchaseInvoiceItemId)
            ->get();
    }
}