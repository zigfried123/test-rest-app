<?php

namespace App\Services\price;

class FactoryCouponCodeCalc
{

    public static function getInstance(string $couponCode, int $price)
    {
        return new CouponCodePercentCalc($couponCode, $price);
    }
}