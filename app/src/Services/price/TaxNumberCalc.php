<?php

namespace App\Services\price;

class TaxNumberCalc
{
    use ChainPriceCalc;
    const TaxPercentDE = 19;
    const TaxPercentIT = 22;
    const TaxPercentFR = 20;
    const TaxPercentGR = 24;

    private string $taxNumber;

    public function __construct(string $taxNumber, int|float $total)
    {
        $this->taxNumber = $taxNumber;
        $this->total = $total;
    }

    private function getCalculatedValue(): int|float
    {
        $taxPercent = null;
        if (strpos($this->taxNumber, 'DE') !== false) {
            $taxPercent = self::TaxPercentDE;
        } elseif (strpos($this->taxNumber, 'IT') !== false) {
            $taxPercent = self::TaxPercentIT;
        } elseif (strpos($this->taxNumber, 'FR') !== false) {
            $taxPercent = self::TaxPercentFR;
        } elseif (strpos($this->taxNumber, 'GR') !== false) {
            $taxPercent = self::TaxPercentGR;
        }
        return $this->total * $taxPercent / 100;
    }

    public function calculate(): int|float
    {
        $calculatedValue = $this->getCalculatedValue();
        $this->total += $calculatedValue;
        return $this->total;
    }
}