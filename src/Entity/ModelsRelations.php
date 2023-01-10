<?php

namespace App\Entity;

use App\Repository\ModelsRelationsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'modelsRelations')]
#[ORM\Entity(repositoryClass: ModelsRelationsRepository::class)]
class ModelsRelations
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(name: 'manufacturerName', length: 100)]
    private ?string $manufacturerName = null;

    #[ORM\Column(name: 'parentName', length: 100)]
    private ?string $parentName = null;

    #[ORM\Column(name: 'modelName', length: 100)]
    private ?string $modelName = null;

    #[ORM\Column(name: 'parentId')]
    private int $parentId;

    #[ORM\Column(name: 'childId')]
    private int $childId;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getManufacturerName(): ?string
    {
        return $this->manufacturerName;
    }

    public function setManufacturerName(string $manufacturerName): self
    {
        $this->manufacturerName = $manufacturerName;

        return $this;
    }

    public function getParentName(): ?string
    {
        return $this->parentName;
    }

    public function setParentName(string $parentName): self
    {
        $this->parentName = $parentName;

        return $this;
    }

    public function getModelName(): ?string
    {
        return $this->modelName;
    }

    public function setModelName(string $modelName): self
    {
        $this->modelName = $modelName;

        return $this;
    }

    public function getParentId(): int
    {
        return $this->parentId;
    }

    public function getChildId(): int
    {
        return $this->childId;
    }
}
