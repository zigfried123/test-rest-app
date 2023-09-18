<?php

namespace App\Services\payment;

use Systemeio\TestForCandidates\PaymentProcessor\PaypalPaymentProcessor;
use Systemeio\TestForCandidates\PaymentProcessor\StripePaymentProcessor;

class Payment
{
    public static function pay(string $paymentProcessor, int $price)
    {
        match ($paymentProcessor) {
            'paypal' => (new PaypalPaymentProcessor)->pay($price),
            'stripe' => (new StripePaymentProcessor)->processPayment($price)
        };
    }
}