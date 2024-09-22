<?php

namespace App\Entity;

use App\Repository\InventoryErrorRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InventoryErrorRepository::class)]
class InventoryError
{
    #[ORM\Id]
    #[ORM\Column(name: 'id', type: 'guid')]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    private ?string $id;

    #[ORM\ManyToOne(targetEntity: DocumentItem::class, inversedBy: 'inventoryErrors')]
    #[ORM\JoinColumn(name: 'document_item_id', nullable: false)]
    private DocumentItem $documentItem;

    #[ORM\Column(type: 'integer')]
    private int $calculatedStock;

    #[ORM\Column(type: 'integer')]
    private int $error;

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getDocumentItem(): DocumentItem
    {
        return $this->documentItem;
    }

    public function getCalculatedStock(): int
    {
        return $this->calculatedStock;
    }

    public function getError(): int
    {
        return $this->error;
    }

    public function setDocumentItem(DocumentItem $documentItem): self
    {
        $this->documentItem = $documentItem;

        return $this;
    }

    public function setCalculatedStock(int $calculatedStock): self
    {
        $this->calculatedStock = $calculatedStock;

        return $this;
    }

    public function setError(int $error): self
    {
        $this->error = $error;

        return $this;
    }
}
