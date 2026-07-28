<?php

namespace Bits\Package\Repositories;

use Bits\Package\Models\Invoice;

class InvoiceRepository extends BaseRepository
{
    public function __construct(Invoice $model, ?int $hotelId = null)
    {
        parent::__construct($model, $hotelId);
    }

    /**
     * Create invoice with items
     */
    public function createWithItems(array $invoiceData, array $itemsData)
    {
        // Invoice creation handled by BaseRepo or manual if complex
        $invoice = $this->create($invoiceData);

        if (!empty($itemsData)) {
            $invoice->items()->createMany($itemsData);
        }

        return $invoice->refresh();
    }

    /**
     * Update invoice and sync items
     */
    public function updateWithItems($id, array $invoiceData, array $itemsData = [])
    {
        $invoice = $this->update($id, $invoiceData);

        if (!empty($itemsData)) {
            // Simple sync: delete all and recreate (easiest for plug-and-play)
            // Or careful update. For now, delete/create is safer to avoid drift.
            $invoice->items()->delete();
            $invoice->items()->createMany($itemsData);
        }

        return $invoice->refresh();
    }
}
