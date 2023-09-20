<?php

namespace App\Service\price;

class Price
{
    const UNIT_EURO = 1;
    const UNIT_CENT = 2;
    const UNIT_USD = 3;

    /**
     * @param string $taxNumber
     * @param string $couponCode
     * @param int $price
     * @return float|int
     * @throws \App\Exception\CouponException
     */
    public function calculate(string $taxNumber, string $couponCode, int $price)
    {
        $handler = FactoryCouponCodeCalc::getInstance($couponCode, $price);
        $total = $handler->calculate();
        $handler->setNext(new TaxNumberCalc($taxNumber, $total));
        $total = $handler->calculate();
        return $total;
    }
}