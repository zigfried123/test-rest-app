<?php

namespace App\Services\price;

class CouponCodeCalc
{

    /**
     * @param string $couponCode
     * @param int $price
     * @return CouponCodeFixCalc
     */
    public static function getInstance(string $couponCode, int $price):CouponCodeFixCalc
    {
        return new CouponCodeFixCalc($couponCode, $price);
    }
}