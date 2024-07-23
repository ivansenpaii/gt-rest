<?php

namespace App\Entity;

use App\Repository\DocumentItemRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DocumentItemRepository::class)]
class DocumentItem
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid')]
    private ?string $id = null;

    #[ORM\ManyToOne(targetEntity: Document::class, inversedBy: 'items')]
    #[ORM\JoinColumn(nullable: false)]
    private Document $document;

    #[ORM\Column(type: 'string')]
    private int $productId;

    #[ORM\Column(type: 'integer')]
    private int $quantity;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2, nullable: true)]
    private ?float $unitPrice;

    public function getId(): ?string
    {
        return $this->id;
    }
}
