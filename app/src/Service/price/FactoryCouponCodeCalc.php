<?php

namespace App\Service\price;

use App\Exception\CouponException;

class FactoryCouponCodeCalc
{

    /**
     * @param string $couponCode
     * @param int $price
     * @return CouponCodeFixCalc|CouponCodePercentCalc
     * @throws CouponException
     */
    public static function getInstance(string $couponCode, int $price)
    {
        if (strpos($couponCode, 'D') !== false) {
            return new CouponCodeFixCalc($couponCode, $price);
        } elseif (strpos($couponCode, 'P') !== false) {
            return new CouponCodePercentCalc($couponCode, $price);
        }
        throw new CouponException('wrong coupon code');
    }
}