<?php

namespace App\Controller\Admin;

use App\Entity\AuditLog;
use App\Entity\Manufacturer;
use App\Entity\ModelCountriesRelation;
use App\Entity\Models;
use App\Entity\ModelsI18n;
use App\Entity\ModelRelation;
use App\Entity\User;
use App\Repository\AuditLogRepository;
use App\Repository\ModelsRepository;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
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
    private AuditLogRepository $auditLogRepository;

    public function __construct(ChartBuilderInterface $chartBuilder, ModelsRepository $modelsRepo, AuditLogRepository $auditLogRepository)
    {
        $this->chartBuilder = $chartBuilder;
        $this->modelsRepo = $modelsRepo;
        $this->auditLogRepository = $auditLogRepository;
    }

    public function configureAssets(): Assets
    {
        return Assets::new()->addCssFile('assets/css/admin.css');
    }

    #[Route('/index', name: 'dashboard_index')]
    public function index(): Response
    {
        return $this->dashboard();
    }

    #[Route('/dashboard', name: 'dashboard_admin')]
    public function dashboard(): Response
    {
        $data = $this->auditLogRepository->findLast(15);
        return $this->render('admin/dashboard.html.twig', [
            'totalManufacturers' => 1982, //todo: get real number
            'totalModels' => 3994, //todo: get real number
            'manuModChart' => $this->getManufacturersChart(),
            'modTransChart' => $this->getModelsTranslationsChart(),
            'entities' => $data,
        ]);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Manufacturers + Models Tool');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Manufacturers', 'fa-solid fa-industry', Manufacturer::class);
        yield MenuItem::subMenu('Models', 'fa fa-car')->setSubItems([
            MenuItem::linkToCrud('List', 'fa-solid fa-car-side', Models::class),
            MenuItem::linkToCrud('Translations', 'fa-solid fa-language', ModelsI18n::class),
            MenuItem::linkToCrud('Model Relations', 'fa-solid fa-people-roof', ModelRelation::class),
            MenuItem::linkToCrud('Country Relations', 'fa-solid fa-earth-europe', ModelCountriesRelation::class),
        ]);
        yield MenuItem::linkToCrud('Users', 'fa-solid fa-users', User::class)->setPermission('ROLE_ADMIN');
        yield MenuItem::linkToCrud('Audit Log', 'fa-solid fa-fingerprint', AuditLog::class)->setPermission('ROLE_ADMIN');
    }

    private function getManufacturersChart(): Chart
    {
        $dataSet = $this->modelsRepo->findModelsCountByManufacturer();
        $title = 'Top 15 Manufacturers Model count';
        return $this->createChart($dataSet, $title);
    }

    private function getModelsTranslationsChart(): Chart
    {
        $dataSet = $this->modelsRepo->findModelsCountByTranslations();
        $title = 'Top 5 Most Translated Models';
        return $this->createChart($dataSet, $title);
    }

    private function createChart(array $dataSet, string $title): Chart
    {
        $chart = $this->chartBuilder->createChart(Chart::TYPE_BAR);
        $chart->setData([
            'datasets' => [
                [
                    'label' => 'Count',
                    'backgroundColor' => 'rgb(255, 80, 0)',
                    'borderColor' => 'rgb(255, 80, 0)',
                    'data' => $dataSet,
                ],
            ],
        ]);

        $chart->setOptions([
            'plugins' => [
                'title' => [
                    'display' => true,
                    'text' => $title,
                ]
            ],
            'parsing' => [
                'xAxisKey' => 'name',
                'yAxisKey' => 'modelsCount',
            ]
        ]);

        return $chart;
    }
}