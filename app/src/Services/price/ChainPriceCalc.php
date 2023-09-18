<?php

namespace App\Services\price;

trait ChainPriceCalc
{
    private $next;
    protected int|float $total;

    public function setNext($next)
    {
        $this->next = $next;
    }

}