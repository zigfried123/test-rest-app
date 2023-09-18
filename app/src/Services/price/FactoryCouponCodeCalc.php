<?php

namespace App\Services\price;

class FactoryCouponCodeCalc
{

    /**
     * @param string $couponCode
     * @param int $price
     * @return CouponCodeFixCalc
     */
    public static function getInstance(string $couponCode, int $price)
    {
        return new CouponCodePercentCalc($couponCode, $price);
    }
}