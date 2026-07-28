<?php

namespace Bits\Payment\Events;

class PaymentSuccessful
{
    public function __construct(
        public int $paymentId,
        public string $transactionId,
        public string $gateway = 'razorpay'
    ) {}
}