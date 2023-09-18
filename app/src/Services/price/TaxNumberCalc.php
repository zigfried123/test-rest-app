<?php

namespace App\Services\price;

class TaxNumberCalc
{
    use ChainPriceCalc;

    private string $taxNumber;

    public function __construct(string $taxNumber, int $total)
    {
        $this->taxNumber = $taxNumber;
        $this->total = $total;
    }

    public function getCalculatedValue()
    {
        $taxPercent = null;
        if (strpos($this->taxNumber, 'DE') !== false) {
            $taxPercent = 19;
        } elseif (strpos($this->taxNumber, 'IT') !== false) {
            $taxPercent = 22;
        } elseif (strpos($this->taxNumber, 'FR') !== false) {
            $taxPercent = 20;
        } elseif (strpos($this->taxNumber, 'GR') !== false) {
            $taxPercent = 24;
        }
        return $this->total * $taxPercent / 100;
    }

    public function calculate(): int
    {
        $calculatedValue = $this->getCalculatedValue();
        $this->total += $calculatedValue;
        return $this->total;
    }
}