<?php

namespace App\Services\price;

class Price
{
    public function calculate(string $taxNumber, string $couponCode, int $price): int|float
    {
        $handler = FactoryCouponCodeCalc::getInstance($couponCode, $price);
        $total = $handler->calculate();
        $handler->setNext(new TaxNumberCalc($taxNumber, $total));
        $total = $handler->calculate();
        return $total;
    }
}