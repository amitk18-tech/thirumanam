<?php

namespace Bits\Payment\Events;

class PaymentFailed
{
    public function __construct(
        public int $paymentId,
        public string $transactionId,
        public string $reason = ''
    ) {}
}