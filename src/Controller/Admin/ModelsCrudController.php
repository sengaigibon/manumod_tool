<?php

namespace App\Controller\Admin;

use App\Entity\Models;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ModelsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Models::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
