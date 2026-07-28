<?php

namespace Bits\Package\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceSetting extends Model
{
    use HasFactory;

    protected $table = 'bits_invoice_settings';
    protected $guarded = ['id'];

    protected $casts = [
        'tax_enabled' => 'boolean',
        'default_tax_percent' => 'decimal:2',
    ];
}
