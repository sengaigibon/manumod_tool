<?php

namespace App\Controller\Admin;

use App\Entity\ModelCountriesRelation;
use App\Repository\ModelCountriesRelationRepository;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;

class ModelCountriesRelationCrudController extends AbstractCrudController
{
    private ModelCountriesRelationRepository $countryRelationsRepo;

    public function __construct(ModelCountriesRelationRepository $countryRelationsRepo)
    {
        $this->countryRelationsRepo = $countryRelationsRepo;
    }

    public static function getEntityFqcn(): string
    {
        return ModelCountriesRelation::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->remove(Crud::PAGE_NEW, Action::SAVE_AND_ADD_ANOTHER)
            ->remove(Crud::PAGE_NEW, Action::SAVE_AND_RETURN)
            ->add(Crud::PAGE_NEW, Action::INDEX)
            ;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud->setPageTitle('index', 'Model-Country Relations')
            ->setEntityLabelInSingular('Country relation')
            ->setEntityLabelInPlural('Countries relation')
            ->overrideTemplate('crud/new', 'bundles/EasyAdminBundle/crud/new.html.twig');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            AssociationField::new('model')->setLabel('Model'),
            AssociationField::new('country')
                ->setLabel('Country')
                ->setFormTypeOption('multiple', true),
            BooleanField::new('allCountries')->hideOnIndex()->setLabel('All Countries')
        ];
    }
}
