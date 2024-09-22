<?php

namespace App\DTO\Request\Document;

use App\Enum\Entity\DocumentType;
use Symfony\Component\Validator\Constraints as Assert;

class CreateDocument
{
    public function __construct(
        #[Assert\Choice([DocumentType::INCOMING->value, DocumentType::INVENTORY->value, DocumentType::OUTGOING->value])]
        #[Assert\NotBlank(allowNull: false)]
        #[Assert\Type('string')]
        public string $type,

        /** @var Item[] */
        #[Assert\NotBlank(allowNull: false)]
        #[Assert\Valid]
        #[Assert\Type('array')]
        public array $items,
    ) {
    }
}
