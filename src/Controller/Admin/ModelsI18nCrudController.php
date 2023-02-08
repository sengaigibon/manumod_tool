<?php

namespace App\Controller\Admin;

use App\Entity\ModelsI18n;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;

class ModelsI18nCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ModelsI18n::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud->setPageTitle('index', 'Models Translations')
            ->setEntityLabelInSingular('Translation')
            ->setEntityLabelInPlural('Translations');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            Field::new('modelid', 'Model ID'),
            AssociationField::new('countryid', 'Country'),
            Field::new('languageid', 'Language'),
            Field::new('name', 'Model Name'),
            Field::new('ident_code', 'Identification Code'),
        ];
    }
}
