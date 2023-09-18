<?php

namespace App\Services\price;

abstract class AbstractCouponCodeCalc
{
    use ChainPriceCalc;

    protected string $couponCode;

    public function __construct(string $couponCode, int|float $total)
    {
        $this->couponCode = $couponCode;
        $this->total = $total;
    }

    public function calculate()
    {
        if($this->next) {
            return $this->next->calculate();
        }else{
            return $this->total;
        }
    }
}