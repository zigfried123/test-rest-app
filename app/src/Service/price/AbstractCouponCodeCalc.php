<?php

namespace App\Service\price;

abstract class AbstractCouponCodeCalc
{
    use ChainPriceCalc;

    protected string $couponCode;

    public function __construct(string $couponCode, int|float $total)
    {
        $this->couponCode = $couponCode;
        $this->total = $total;
    }

}