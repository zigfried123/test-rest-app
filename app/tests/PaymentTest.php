<?php

namespace App\Tests;

use App\Service\payment\PaymentAdapter;
use PHPUnit\Framework\TestCase;

class PaymentTest extends TestCase
{
    public function testPaypal(): void
    {
        $this->expectExceptionMessage('Too high price');

        (new PaymentAdapter)->pay('paypal',101000);

    }

    public function testStripe(): void
    {
        $this->assertTrue((new PaymentAdapter)->pay('stripe',100));
    }
}