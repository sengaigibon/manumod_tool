<?php

namespace App\Controller\Admin;

use App\Entity\Manufacturer;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ManufacturerCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Manufacturer::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud->setPageTitle('index', 'Manufacturers')
            ->setEntityLabelInSingular('Manufacturer')
            ->setEntityLabelInPlural('Manufacturers');
    }
}
