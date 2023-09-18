<?php

namespace App\Services\price;

abstract class AbstractCouponCodeCalc
{
    use TraitPriceCalc;

    private string $couponCode;

    /**
     * @param string $couponCode
     * @param int $total
     */
    public function __construct(string $couponCode, int $total)
    {
        $this->couponCode = $couponCode;
        $this->total = $total;
    }
}