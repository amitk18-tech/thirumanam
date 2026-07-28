<?php

namespace Bits\Package\Repositories;

use Bits\Package\Models\InvoiceSetting;

class InvoiceSettingRepository extends BaseRepository
{
    public function __construct(InvoiceSetting $model, ?int $hotelId = null)
    {
        parent::__construct($model, $hotelId);
    }

    public function getSettings()
    {
        // Usually one setting per tenant
        $query = $this->model->newQuery();
        // Removed tenant check
        return $query->first();
    }
}
