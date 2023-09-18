<?php

namespace App\Services\price;

class CouponCodeFixCalc extends AbstractCouponCodeCalc
{

    public function getCalculatedValue(): int
    {
        preg_match('/\d+/', $this->couponCode, $matches);
        return +$matches[0];
    }

    /**
     * @return int
     */
    public function calculate(): int
    {
        $calculatedValue = $this->getCalculatedValue();
        $this->total -= $calculatedValue;
        return $this->total;
    }
}