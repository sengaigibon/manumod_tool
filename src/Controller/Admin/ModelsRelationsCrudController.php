<?php

namespace App\Controller\Admin;

use App\Entity\ModelsRelations;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;

class ModelsRelationsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ModelsRelations::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud->setPageTitle('index', 'Models & Relations');
    }

    public function configureActions(Actions $actions): Actions
    {
        $customDelete = Action::new('linkModels', 'Delete')
            ->displayAsLink()
            ->setCssClass('text-danger')
            ->linkToRoute('app_models_delete_link',
            function (ModelsRelations $modelRelation): array {
                return [
                    'parentId' => $modelRelation->getParentId(),
                    'childId' => $modelRelation->getChildId(),
                ];
            });


        return $actions
            ->remove(Crud::PAGE_INDEX, Action::NEW)
            ->remove(Crud::PAGE_INDEX, Action::EDIT)
            ->remove(Crud::PAGE_INDEX, Action::DELETE)
            ->add(Crud::PAGE_INDEX, $customDelete);
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('manufacturerName'),
            TextField::new('parentName'),
            TextField::new('modelName'),
        ];
    }
}
