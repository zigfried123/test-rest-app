<?php

namespace App\Service\payment;

use App\Service\price\Price;
use Systemeio\TestForCandidates\PaymentProcessor\PaypalPaymentProcessor;
use Systemeio\TestForCandidates\PaymentProcessor\StripePaymentProcessor;

class PaymentAdapter
{
    public function pay(string $paymentProcessor, int|float $price, int $unit=Price::UNIT_EURO)
    {
        return match ($paymentProcessor) {
            'paypal' => (new PaypalPaymentProcessor)->pay($price),
            'stripe' => (new StripePaymentProcessor)->processPayment($price)
        };
    }
}