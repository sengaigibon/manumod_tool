<?php

namespace App\Entity;

use App\Repository\ModelsParentRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: "mdx_kfz_model_parent")]
#[ORM\Entity(repositoryClass: ModelsParentRepository::class)]
class ModelsParent
{
    #[ORM\Id]
    #[ORM\Column(name: "modelId")]
    private int $modelId;

    #[ORM\Column(name: "parentModelId")]
    private int $parentModelId;

    public function getModelId(): int
    {
        return $this->modelId;
    }

    public function setModelId(int $modelId): void
    {
        $this->modelId = $modelId;
    }

    public function getParentModelId(): int
    {
        return $this->parentModelId;
    }

    public function setParentModelId(int $parentModelId): void
    {
        $this->parentModelId = $parentModelId;
    }
}
