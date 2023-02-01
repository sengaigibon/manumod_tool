<?php

namespace App\Controller\Admin;

use App\Entity\Manufacturer;
use App\Entity\Models;
use App\Entity\ModelsI18n;
use App\Entity\ModelsRelations;
use App\Repository\ModelsRepository;
use Doctrine\Persistence\ManagerRegistry;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;

class DashboardController extends AbstractDashboardController
{
    private ChartBuilderInterface $chartBuilder;
    private ModelsRepository $modelsRepo;

    public function __construct(ChartBuilderInterface $chartBuilder, ModelsRepository $modelsRepo)
    {
        $this->chartBuilder = $chartBuilder;
        $this->modelsRepo = $modelsRepo;
    }

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
            'chart' => $this->getManufacturersChart(),
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

    private function getManufacturersChart(): Chart
    {
        $dataSet = $this->modelsRepo->findModelsCountByManufacturer();

        $labels = array_column($dataSet, 'name');
        $data = array_column($dataSet, 'modelsCount');

        $chart = $this->chartBuilder->createChart(Chart::TYPE_BAR);
        $chart->setData([
            'labels' => $labels,
            'datasets' => [
                [
                    'axis' => 'y',
                    'label' => 'Model count (Top 15 brands)',
                    'backgroundColor' => 'rgb(255, 80, 0)',
                    'borderColor' => 'rgb(255, 80, 0)',
                    'data' => $data,
                ],
            ],
        ]);

        $chart->setOptions([
            'scales' => [
                'y' => [
                    'suggestedMin' => 0,
                    'suggestedMax' => 100,
                ],
            ],
        ]);

        return $chart;
    }
}