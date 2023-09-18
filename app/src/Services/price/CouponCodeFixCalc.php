<?php

namespace App\Services\price;

class CouponCodeFixCalc extends AbstractCouponCodeCalc
{
    /**
     * @return int
     */
    public function calculate()
    {
        $this->total -= 25;
        return $this->total;
    }
}