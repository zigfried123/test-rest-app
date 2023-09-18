<?php

namespace App\Services\price;

trait TraitPriceCalc
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

   abstract function calculate();
}