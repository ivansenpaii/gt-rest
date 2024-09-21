<?php

namespace App\DTO\Request;

use Symfony\Component\Validator\Constraints as Assert;

class CreateDocument
{
    public function __construct(
        #[Assert\Length(min: 10, max: 500)]
        public string $name
    ) {

    }
}