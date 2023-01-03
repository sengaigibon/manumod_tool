<?php

namespace App\Entity;

use App\Repository\ModelsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: "mdx_kfz_models")]
#[ORM\Entity(repositoryClass: ModelsRepository::class)]
class Models
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $herst = null;

    #[ORM\Column(length: 100)]
    private ?string $name = null;

    #[ORM\Column(length: 80)]
    private ?string $ident_code = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHerst(): ?int
    {
        return $this->herst;
    }

    public function setHerst(int $herst): self
    {
        $this->herst = $herst;

        return $this;
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
}
