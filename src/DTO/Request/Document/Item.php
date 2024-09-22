<?php

namespace App\DTO\Request\Document;

use App\Enum\Entity\DocumentType;
use Symfony\Component\Validator\Constraints as Assert;

class Item
{
    public function __construct(
        #[Assert\NotBlank(allowNull: false)]
        #[Assert\Type('string')]
        public string $productId,

        #[Assert\NotBlank(allowNull: false)]
        #[Assert\Type('int')]
        public int $quantity,

        public ?float $unitPrice,
    ) {
    }
}
