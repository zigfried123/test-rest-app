<?php

namespace App\Provider;

use Symfony\Component\Validator\Constraints as Assert;

class CalculatePriceParams
{
    public function __construct(array $params)
    {
        foreach ($params as $param => $value) {
            $this->$param = $value;
        }
    }

    #[Assert\NotBlank]
    #[Assert\Range(min: 1,max: 3,notInRangeMessage: 'choose beetween 1 and 3')]
    public $product;

    #[Assert\NotBlank]
    #[Assert\Regex(pattern: '/^DE|IT|GR|FR[A-Z]{2}[A-Z0-9]+$/',message: 'Your taxNumber is wrong')]
    public $taxNumber;

    #[Assert\NotBlank]
    public $couponCode;

}