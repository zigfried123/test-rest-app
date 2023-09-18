<?php

namespace App\Services\price;

class CouponCodePercentCalc extends AbstractCouponCodeCalc
{

    public function getCalculatedValue(): int
    {
        preg_match('/\d+/', $this->couponCode, $matches);
        $percent = +$matches[0];
        return $this->total * $percent / 100;
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