<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ModelRelationsController extends AbstractController
{


    #[Route('/model/relations', name: 'app_model_relations')]
    public function content(): Response
    {
        return $this->render('model_relations/index.html.twig', [
            'controller_name' => 'ModelRelationsController',
        ]);
    }
}
