<?php

namespace App\Controller\Admin;

use App\Entity\Manufacturer;
use App\Entity\Models;
use App\Entity\ModelsI18n;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        /** @var AdminUrlGenerator $routeBuilder */
        $routeBuilder = $this->container->get(AdminUrlGenerator::class);
        $url = $routeBuilder->setController(ManufacturerCrudController::class)->generateUrl();

        return $this->redirect($url);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Manufacturers + Modules Tool');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
//        yield MenuItem::linkToRoute('Back to the website', 'fas fa-home', 'homepage');
        yield MenuItem::linkToCrud('Manufacturers', 'fa-solid fa-industry', Manufacturer::class);
        yield MenuItem::linkToCrud('Models', 'fa-solid fa-car-side', Models::class);
        yield MenuItem::linkToCrud('Models i18n', 'fa-solid fa-language', ModelsI18n::class);
    }
}
