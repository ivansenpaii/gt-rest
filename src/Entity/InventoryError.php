<?php

namespace App\Entity;

use App\Repository\InventoryErrorRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InventoryErrorRepository::class)]
class InventoryError
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid')]
    private ?string $id = null;

    #[ORM\ManyToOne(targetEntity: DocumentItem::class, inversedBy: 'inventoryErrors')]
    #[ORM\JoinColumn(nullable: false)]
    private DocumentItem $documentItem;

    #[ORM\Column(type: 'integer')]
    private int $calculatedStock;

    #[ORM\Column(type: 'integer')]
    private int $error;

    public function getId(): ?string
    {
        return $this->id;
    }
}
