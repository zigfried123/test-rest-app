<?php

namespace App\Services\payment;

use Systemeio\TestForCandidates\PaymentProcessor\PaypalPaymentProcessor;
use Systemeio\TestForCandidates\PaymentProcessor\StripePaymentProcessor;

class PaymentAdapter
{
    public function pay($paymentProcessor, $price)
    {
        return match ($paymentProcessor) {
            'paypal' => (new PaypalPaymentProcessor)->pay($price),
            'stripe' => (new StripePaymentProcessor)->processPayment($price)
        };
    }
}