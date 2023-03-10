<?php

namespace App\Entity;

use App\Repository\ModelsRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Ignore;

#[ORM\Table(name: "mdx_kfz_models")]
#[ORM\Entity(repositoryClass: ModelsRepository::class)]
class Models
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Ignore]
    #[ORM\ManyToOne(targetEntity: Manufacturer::class, inversedBy: 'id')]
    #[ORM\JoinColumn(name: 'herst', referencedColumnName: 'id')]
    private Manufacturer $herst;

    #[Ignore]
    #[ORM\OneToOne(targetEntity: ModelsParent::class)]
    #[ORM\JoinColumn(name: 'id', referencedColumnName: 'modelId', nullable: true)]
    private ModelsParent|null $parent = null;

    #[ORM\Column(length: 100)]
    private ?string $name = null;

    #[ORM\Column(length: 80)]
    private ?string $ident_code = null;

    public function __toString()
    {
        return $this->name;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHerst(): ?Manufacturer
    {
        return $this->herst;
    }

    public function setHerst(Manufacturer $manufacturer): self
    {
        $this->herst = $manufacturer;

        return $this;
    }

    public function getManufacturerId(): int
    {
        return $this->herst->getId();
    }

    public function getManufacturerName(): string
    {
        return $this->herst->getName();
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getIdentCode(): ?string
    {
        return $this->ident_code;
    }

    public function setIdentCode(string $ident_code): self
    {
        $this->ident_code = $ident_code;

        return $this;
    }

    public function __serialize(): array
    {
        return [
            'id' => $this->id,
            'manufacturerId' => $this->herst->getId(),
            'manufacturerName' => $this->herst->getName(),
            'name' => $this->name,
            'ident_code' => $this->ident_code,
        ];
    }

    public function getParent(): ?ModelsParent
    {
        if (!$this->parent) {
            return null;
        }

        try {
            $this->parent->getParentModelId();
        } catch (\Doctrine\ORM\EntityNotFoundException $e) {
            return $this->parent = null;
        }

        return $this->parent;
    }

    public function setParent(?ModelsParent $parent): Models
    {
        $this->parent = $parent;
        return $this;
    }

    public function isOrphan(): bool
    {
        return empty($this->parent);
    }
}
