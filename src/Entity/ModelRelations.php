<?php

namespace App\Entity;

#[ORM\Table(name: "mdx_kfz_model_parent")]
class ModelRelations
{
    private int $modelId;
    private int $parentModelId;
}