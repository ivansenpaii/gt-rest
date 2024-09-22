<?php

namespace App\Entity;

use App\Repository\DocumentItemRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DocumentItemRepository::class)]
class DocumentItem
{
    #[ORM\Id]
    #[ORM\Column(name: 'id', type: 'guid')]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    private ?string $id;

    #[ORM\ManyToOne(targetEntity: Document::class, inversedBy: 'items')]
    #[ORM\JoinColumn(nullable: false)]
    private Document $document;

    #[ORM\Column(type: 'string')]
    private string $productId;

    #[ORM\Column(type: 'integer')]
    private int $quantity;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2, nullable: true)]
    private ?float $unitPrice;

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getDocument(): Document
    {
        return $this->document;
    }

    public function getProductId(): string
    {
        return $this->productId;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function getUnitPrice(): ?float
    {
        return $this->unitPrice;
    }

    public function setDocument(Document $document): self
    {
        $this->document = $document;
        return $this;
    }

    public function setProductId(string $productId): self
    {
        $this->productId = $productId;
        return $this;
    }

    public function setQuantity(int $quantity): DocumentItem
    {
        $this->quantity = $quantity;
        return $this;
    }

    public function setUnitPrice(?float $unitPrice): DocumentItem
    {
        $this->unitPrice = $unitPrice;
        return $this;
    }
}
