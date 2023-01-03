<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RandomController extends AbstractController
{
    #[Route('/random/number')]
    public function number(): Response
    {
        $number = random_int(0, 100);

        return $this->render('random/number.html.twig', [
            'number' => $number
        ]);
    }

    #[Route('/random/float')]
    public function float(): Response
    {
        return new Response(
            '<html><body> FLOAT </body></html>'
        );
    }
}