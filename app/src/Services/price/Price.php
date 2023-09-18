<?php

namespace App\Services\price;

class Price
{
    /**
     * @param string $taxNumber
     * @param string $couponCode
     * @param int $price
     * @return int
     */
    public function count(string $taxNumber, string $couponCode, int $price): int
    {
        $handler = FactoryCouponCodeCalc::getInstance($couponCode, $price);
        $total = $handler->calculate();
        $handler->setNext(new TaxNumberCalc($taxNumber, $total));
        $total = $handler->calculate();
        return $total;
    }
}