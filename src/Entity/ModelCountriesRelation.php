<?php

namespace App\Entity;

use App\Repository\ModelCountriesRelationRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Ignore;

#[ORM\Table(name: "mdx_kfz_model_countries")]
#[ORM\Entity(repositoryClass: ModelCountriesRelationRepository::class)]
class ModelCountriesRelation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: "id")]
    private ?int $id = null;

    #[Ignore]
    #[ORM\ManyToOne(targetEntity: Models::class, inversedBy: 'id')]
    #[ORM\JoinColumn(name: "modelId", referencedColumnName: 'id')]
    private Models|null $model = null;

    #[Ignore]
    #[ORM\ManyToOne(targetEntity: Country::class, inversedBy: 'id')]
    #[ORM\JoinColumn(name: "countryId", referencedColumnName: 'id')]
    private Country|null $country = null;

    #[ORM\Column(name: "modelId")]
    private int $modelId;

    #[ORM\Column(name: "countryId")]
    private int $countryId;

    private bool $allCountries = false;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getModel(): ?Models
    {
        return $this->model;
    }

    public function setModel(Models|null $model): ModelCountriesRelation
    {
        $this->model = $model;
        return $this;
    }

    public function getCountry(): ?Country
    {
        return $this->country;
    }

    public function setCountry(Country|null $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getModelId(): int
    {
        return $this->modelId;
    }

    public function setModelId(int $modelId): void
    {
        $this->modelId = $modelId;
    }

    public function getCountryId(): int
    {
        return $this->countryId;
    }

    public function setCountryId(int $countryId): void
    {
        $this->countryId = $countryId;
    }

    /**
     * Dummy function for rendering a checkbox in the add new relation form, crud controller
     */
    public function getAllCountries(): bool
    {
        return $this->allCountries;
    }

    public function setAllCountries(bool $allCountries): void
    {
        $this->allCountries = $allCountries;
    }
}