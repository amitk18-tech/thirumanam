<?php

namespace Bits\Package\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'payments';

    protected $fillable = [
        'amount',
        'status',
        'gateway',
        'payment_method',
        'transaction_id',
        'reference_type',
        'reference_id',
        'paid_at',
    ];

    protected $casts = [
        'paid_at' => 'datetime',
        'amount'  => 'decimal:2',
    ];

    /**
     * Scope helpers (optional but useful)
     */
    public function scopeInitiated($query)
    {
        return $query->where('status', 'initiated');
    }

    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }

    public function scopeFailed($query)
    {
        return $query->where('status', 'failed');
    }
}
