<?php

namespace App\Tests;

use App\Services\price\Price;
use PHPUnit\Framework\TestCase;

class CalculatePriceTest extends TestCase
{
    public function testCalculate(): void
    {
        //taxNumber FRFJ123456789 20%
        //couponCode D15 15%
        //price 100
        // 100 - 15% + 20% = 102

        $this->assertEquals(102,(new Price)->calculate('FRFJ123456789', 'D15', 100));
    }
}
