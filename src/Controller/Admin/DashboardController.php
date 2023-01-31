<?php

namespace App\Controller\Admin;

use App\Entity\Country;
use App\Entity\Manufacturer;
use App\Entity\Models;
use App\Entity\ModelsI18n;
use App\Entity\ModelsRelations;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/index', name: 'dashboard_index')]
    public function index(): Response
    {
        return $this->dashboard();
    }

    #[Route('/dashboard', name: 'dashboard_admin')]
    public function dashboard(): Response
    {

        return $this->render('admin/dashboard.html.twig', [
            'totalManufacturers' => 1982,
            'totalModels' => 3994,
        ]);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Manufacturers + Modules Tool');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Manufacturers', 'fa-solid fa-industry', Manufacturer::class);
        yield MenuItem::subMenu('Models', 'fa fa-car')->setSubItems([
            MenuItem::linkToCrud('List', 'fa-solid fa-car-side', Models::class),
            MenuItem::linkToCrud('Translations', 'fa-solid fa-language', ModelsI18n::class),
            MenuItem::linkToCrud('Model relations', 'fa-solid fa-people-roof', ModelsRelations::class),
        ]);
    }
}