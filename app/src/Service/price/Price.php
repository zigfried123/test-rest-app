<?php

namespace App\Service\price;

class Price
{
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