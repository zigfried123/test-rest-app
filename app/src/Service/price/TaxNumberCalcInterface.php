<?php

namespace App\Service\price;

interface TaxNumberCalcInterface
{
    public function calculate(): int|float;
}