<?php

namespace App\Service\price;

class CouponCodePercentCalc extends AbstractCouponCodeCalc
{

    private function getCalculatedValue(): int|float
    {
        preg_match('/\d+/', $this->couponCode, $matches);
        $percent = +$matches[0];
        return $this->total * $percent / 100;
    }

    public function calculate(): int|float
    {
        $calculatedValue = $this->getCalculatedValue();
        $this->total -= $calculatedValue;
        return parent::calculate();
    }
}