<?php

namespace App\Entity;

use App\Repository\ModelsI18nRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: "mdx_kfz_models_i18n")]
#[ORM\Entity(repositoryClass: ModelsI18nRepository::class)]
class ModelsI18n
{
    #[ORM\Id]
    #[ORM\Column(name: "modelid")]
    private ?int $modelId = null;

    #[ORM\ManyToOne(targetEntity: Country::class, inversedBy: 'id')]
    #[ORM\JoinColumn(name: 'countryid', referencedColumnName: 'id')]
    private Country|null $countryid = null;

    #[ORM\ManyToOne(targetEntity: Language::class, inversedBy: 'id')]
    #[ORM\JoinColumn(name: 'languageid', referencedColumnName: 'id')]
    private Language|null $languageId = null;

    #[ORM\Column(length: 80)]
    private ?string $name = null;

    #[ORM\Column(length: 80)]
    private ?string $ident_code = null;

    public function getModelId(): ?int
    {
        return $this->modelId;
    }

    public function setModelId(int $modelId): self
    {
        $this->modelId = $modelId;

        return $this;
    }

    public function getCountryId(): ?Country
    {
        return $this->countryid;
    }

    public function setCountryId(?Country $countryId): self
    {
        $this->countryid = $countryId;

        return $this;
    }

    public function getLanguageId(): ?Language
    {
        return $this->languageId;
    }

    public function setLanguageId(?Language $languageId): self
    {
        $this->languageId = $languageId;

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
