<?php

namespace App\Services\price;

class CouponCodeFixCalc extends AbstractCouponCodeCalc
{

   private function getCalculatedValue(): int|float
    {
        preg_match('/\d+/', $this->couponCode, $matches);
        return +$matches[0];
    }

    public function calculate(): int|float
    {
        $calculatedValue = $this->getCalculatedValue();
        $this->total -= $calculatedValue;
        return parent::calculate();
    }
}