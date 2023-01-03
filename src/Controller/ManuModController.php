<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ManuModController extends AbstractController
{
    #[Route('/', name: 'app_manu_mod')]
    public function index(): Response
    {
        return $this->render('manu_mod/index.html.twig', [
            'controller_name' => 'ManuModController',
        ]);
    }
}
