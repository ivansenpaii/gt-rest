<?php

namespace App\Entity;

use App\Repository\StockMovementRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StockMovementRepository::class)]
class StockMovement
{
    #[ORM\Id]
    #[ORM\Column(name: 'id', type: 'guid')]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    private ?string $id;

    #[ORM\Column(type: 'string')]
    private string $productId;

    #[ORM\Column(type: 'datetime')]
    private \DateTime $movementDate;

    #[ORM\Column(type: 'integer')]
    private int $stock;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2)]
    private float $averagePrice;

    public function getId(): ?string
    {
        return $this->id;
    }
}
