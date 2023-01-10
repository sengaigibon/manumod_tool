<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ModelsRelationsController extends AbstractController
{
    #[Route('/models/relations', name: 'app_models_relations')]
    public function content(): Response
    {
        return $this->render('model_relations/index.html.twig', [
            'controller_name' => 'ModelRelationsController',
        ]);
    }

    #[Route('/models/relations/link/{modelId}', name: 'app_models_link_models')]
    public function linkModels(int $modelId): Response
    {
        return $this->render('models_relations/link-models.html.twig', [
            'modelId' => $modelId,
        ]);
    }
}
