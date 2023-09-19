<?php

namespace App\Tests;

use App\Service\price\Price;
use PHPUnit\Framework\TestCase;

class CalculatePriceTest extends TestCase
{
    public function testCalculate(): void
    {
        //taxNumber FRFJ123456789 20%
        //couponCode D15 15
        //price 100
        // 100 - 15 + 20% = 102

        $this->assertEquals(102,(new Price)->calculate('FRFJ123456789', 'D15', 100));
    }

    public function testCalculateCouponCodePercent(): void
    {
        //taxNumber FRFJ123456789 20%
        //couponCode P15 15%
        //price 20
        // 20 - 15% + 20% = 102

        $this->assertEquals(20.4,(new Price)->calculate('FRFJ123456789', 'P15', 20));
    }

    public function testCalculateCouponCodeFix(): void
    {
        //taxNumber FRFJ123456789 20%
        //couponCode D15 15
        //price 20
        // 20 - 15 + 20% = 102

        $this->assertEquals(6,(new Price)->calculate('FRFJ123456789', 'D15', 20));
    }

    public function testCalculateTaxNumber(): void
    {
        //taxNumber DE123456789 19%
        //couponCode D15 15
        //price 20
        // 20 - 15 + 19% = 102

        $this->assertEquals(5.95,(new Price)->calculate('DE123456789', 'D15', 20));
    }
}
