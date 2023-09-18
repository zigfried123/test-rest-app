<?php

namespace App\Services\price;

trait ChainPriceCalc
{
    protected $handler;
    protected $total;

    /**
     * @param $handler
     * @return void
     */
    public function setNext($handler)
    {
        $this->handler = $handler;
    }

    abstract public function calculate(): int;
}