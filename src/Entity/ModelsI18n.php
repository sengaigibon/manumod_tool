<?php

namespace App\Entity;

use App\Repository\ModelsI18nRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: "mdx_kfz_models_i18n")]
#[ORM\Entity(repositoryClass: ModelsI18nRepository::class)]
class ModelsI18n
{
    #[ORM\Id]
    #[ORM\Column]
    private ?int $modelid = null;

    #[ORM\Column]
    private ?int $countryid = null;

    #[ORM\Column]
    private ?int $languageid = null;

    #[ORM\Column(length: 80)]
    private ?string $name = null;

    #[ORM\Column(length: 80)]
    private ?string $ident_code = null;

    public function getModelId(): ?int
    {
        return $this->modelid;
    }

    public function setModelId(int $modelId): self
    {
        $this->modelid = $modelId;

        return $this;
    }

    public function getCountryId(): ?int
    {
        return $this->countryid;
    }

    public function setCountryId(int $countryId): self
    {
        $this->countryid = $countryd;

        return $this;
    }

    public function getLanguageId(): ?int
    {
        return $this->languageid;
    }

    public function setLanguageId(int $languageId): self
    {
        $this->languageid = $languageId;

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
