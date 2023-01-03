<?php

namespace App\Controller\Admin;

use App\Entity\ModelsI18n;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ModelsI18nCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ModelsI18n::class;
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
