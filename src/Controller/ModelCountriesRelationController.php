<?php

namespace App\Controller;

use App\Repository\ModelCountriesRelationRepository;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ModelCountriesRelationController extends AbstractController
{
    #[Route('/model/countries/relation', name: 'app_model_countries_relation')]
    public function index(): Response
    {
        return $this->render('model_countries_relation/index.html.twig', [
            'controller_name' => 'ModelCountriesRelationController',
        ]);
    }

    #[Route('/model/countries/relation/create/{modelId}/{countries}/{allCountries}', name: 'app_model_countries_relation_create')]
    public function createRelation(ModelCountriesRelationRepository $repo, AdminUrlGenerator $generator, int $modelId, string $countries, int $allCountries): Response
    {
        try {
            if ($allCountries) {
                $repo->createWorldWide($modelId);
            } else {
                foreach (explode(',', $countries) as $countryId) {
                    $repo->create($modelId, $countryId);
                }
            }
            $body = ['status' => 'ok', 'msg' => ''];
            $status = 200;
        } catch (\Throwable $t) {
            $body = ['status' => 'error', 'msg' => $t->getMessage()];
            $status = 418;
        }

        $response = new Response(json_encode($body), $status);
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
}
