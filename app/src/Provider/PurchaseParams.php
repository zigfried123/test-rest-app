<?php

namespace App\Provider;

use Symfony\Component\Validator\Constraints as Assert;

class PurchaseParams
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
    #[Assert\Regex(pattern: '/^GR\d+|IT\d+|DE\d+|FR[A-Z]{2}\d+$/',message: 'Your taxNumber is wrong')]
    public $taxNumber;

    #[Assert\NotBlank]
    #[Assert\Regex(pattern: '/^D|P\d+$/',message: 'Your couponCode is wrong')]
    public $couponCode;

    #[Assert\NotBlank]
    #[Assert\Type('string')]
    public $paymentProcessor;
}