<?php

namespace App\Service\price;

trait ChainPriceCalc
{
    private $next;
    protected int|float $total;

    public function setNext($next)
    {
        $this->next = $next;
    }

    public function calculateParent(): int|float
    {
        if ($this->next) {
            return $this->next->calculate();
        } else {
            return $this->total;
        }
    }

}