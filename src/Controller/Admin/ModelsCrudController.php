<?php

namespace App\Controller\Admin;

use App\Entity\Models;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;

class ModelsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Models::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud->setPageTitle('index', 'Models')
            ->setEntityLabelInSingular('Model')
            ->setEntityLabelInPlural('Models');
    }

    public function configureActions(Actions $actions): Actions
    {
        $linkModels = Action::new('linkModels', 'Link model to parent', 'fa-solid fa-link')
            ->displayIf(function ($entity) {
                return $entity->isOrphan();
            });
        $linkModels->displayAsLink()->linkToRoute('app_models_link_models',
            function (Models $model): array {
                return [
                    'modelId' => $model->getId(),
                    'modelName' => $model->getName(),
                    'manufacturerId' => $model->getManufacturerId(),
                    'manufacturer' => $model->getManufacturerName(),
                ];
            });

        return $actions->add(Crud::PAGE_INDEX, $linkModels);
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            AssociationField::new('herst', 'Manufacturer'),
            Field::new('name', 'Model Name'),
            Field::new('ident_code', 'Identification Code'),
            AssociationField::new('parent', 'Parent Id')->hideOnForm(),
        ];
    }
}