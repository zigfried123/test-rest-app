<?php

namespace App\Services\price;

class CouponCodePercentCalc extends AbstractCouponCodeCalc
{

    public function prepareDiscountAmount()
    {

    }

    /**
     * @return int
     */
    public function calculate()
    {
        $this->total -= 25;
        return $this->total;
    }
}