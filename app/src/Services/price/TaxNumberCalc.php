<?php

namespace App\Services\price;

class TaxNumberCalc
{
    use TraitPriceCalc;

    private string $taxNumber;

    public function __construct(string $taxNumber, int $total)
    {
        $this->taxNumber = $taxNumber;
        $this->total = $total;
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