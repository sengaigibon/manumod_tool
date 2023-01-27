<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home', methods: "GET")]
    public function home(): Response
    {
        return $this->render('home.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    #[Route('/login', name: "app_login")]
    public function login()
    {
        return;
    }

    #[Route('/logout', name: "app_out")]
    public function logout()
    {
        return;
    }
}
