<?php

namespace App\Entity;

use App\Repository\ManufacturerRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: "mdx_kfz_herst")]
#[ORM\Entity(repositoryClass: ManufacturerRepository::class)]
class Manufacturer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Column(length: 200)]
    private ?string $name = null;

    #[ORM\Column(length: 30, nullable: true)]
    private ?string $mobileint = null;

    #[ORM\Column]
    private ?int $mobiliti = null;

    #[ORM\Column(length: 2, nullable: true)]
    private ?string $audi = null;

    #[ORM\Column]
    private ?int $mg = null;

    #[ORM\Column(length: 4, nullable: true)]
    private ?string $webmobil = null;

    #[ORM\Column]
    private ?int $msh = null;

    #[ORM\Column(nullable: true)]
    private ?int $vlan = null;

    #[ORM\Column(length: 30, nullable: true)]
    private ?string $kfz = null;

    public function __toString(): string
    {
        return $this->id . ' ' . $this->name;
    }

    public function getId(): int
    {
        return $this->id;
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

    public function getMobileInt(): ?string
    {
        return $this->mobileint;
    }

    public function setMobileInt(?string $mobileInt): self
    {
        $this->mobileint = $mobileInt;

        return $this;
    }

    public function getMobiliti(): ?int
    {
        return $this->mobiliti;
    }

    public function setMobiliti(int $mobiliti): self
    {
        $this->mobiliti = $mobiliti;

        return $this;
    }

    public function getAudi(): ?string
    {
        return $this->audi;
    }

    public function setAudi(?string $audi): self
    {
        $this->audi = $audi;

        return $this;
    }

    public function getMg(): ?int
    {
        return $this->mg;
    }

    public function setMg(int $mg): self
    {
        $this->mg = $mg;

        return $this;
    }

    public function getWebmobil(): ?string
    {
        return $this->webmobil;
    }

    public function setWebmobil(?string $webmobil): self
    {
        $this->webmobil = $webmobil;

        return $this;
    }

    public function getMsh(): ?int
    {
        return $this->msh;
    }

    public function setMsh(int $msh): self
    {
        $this->msh = $msh;

        return $this;
    }

    public function getVlan(): ?int
    {
        return $this->vlan;
    }

    public function setVlan(?int $vlan): self
    {
        $this->vlan = $vlan;

        return $this;
    }

    public function getKfz(): ?string
    {
        return $this->kfz;
    }

    public function setKfz(?string $kfz): self
    {
        $this->kfz = $kfz;

        return $this;
    }
}
