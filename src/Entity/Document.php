<?php

namespace App\Entity;

use App\Enum\Entity\DocumentType;
use App\Repository\DocumentRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DocumentRepository::class)]
class Document
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid')]
    private ?string $id = null;

    #[ORM\Column(type: 'string', length: 50, enumType: DocumentType::class)]
    private string $type;

    #[ORM\Column(type: 'datetime')]
    private DateTime $createdAt;

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function setId(?string $id): Document
    {
        $this->id = $id;
        return $this;
    }

    public function setType(string $type): Document
    {
        $this->type = $type;
        return $this;
    }

    public function setCreatedAt(DateTime $createdAt): Document
    {
        $this->createdAt = $createdAt;
        return $this;
    }
}
