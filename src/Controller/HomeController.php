<?php

namespace App\Controller;

use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Services\OktaApi;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;

class HomeController extends AbstractController
{
    private SessionInterface $session;
    private OktaApi $okta;
    private UserRepository $userRepository;
    private ChartBuilderInterface $chartBuilder;

    public function __construct(RequestStack $requestStack, OktaApi $okta, UserRepository $repo, ChartBuilderInterface $chartBuilder)
    {
        $this->session = $requestStack->getSession();
        $this->okta = $okta;
        $this->userRepository = $repo;
        $this->chartBuilder = $chartBuilder;
    }

    #[Route('/', name: 'app_home', methods: "GET")]
    public function home(): Response
    {
        $chart = $this->chartBuilder->createChart(Chart::TYPE_LINE);
        $chart->setData([
            'labels' => ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
            'datasets' => [
                [
                    'label' => 'My First dataset',
                    'backgroundColor' => 'rgb(255, 99, 132)',
                    'borderColor' => 'rgb(255, 99, 132)',
                    'data' => [0, 10, 5, 2, 20, 30, 45],
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

        return $this->render('home.html.twig', [
            'controller_name' => 'HomeController',
            'chart' => $chart,
        ]);
    }

    #[Route('/login', name: "app_login")]
    public function login(): RedirectResponse
    {
        return $this->redirect($this->okta->buildAuthorizeUrl());
    }

    /**
     * @throws Exception
     */
    #[Route('/callback', name: "app_callback")]
    public function callback(): RedirectResponse
    {
        $token = $this->okta->authorizeUser();

        if (!$token) {
            return $this->redirectToRoute('app_home');
        }

        $email = $token->email;
        $user = $this->userRepository->findOneByEmail($email);

        if (!$user) {
            $user = new User();
            $user->setEmail($email);
            $user->setName($token->name);
            $user->setToken($token->at_hash);
            $user->setLastLogin(date("Y-m-d H:i:s", time()));
            $this->userRepository->save($user, true);
        }

        // Manually authenticate the user
        $token = new UsernamePasswordToken($user, 'main', $user->getRoles());
//        try {
            $this->container->get('security.token_storage')->setToken($token);
            $this->session->set('_security_main', serialize($token));
//        } catch (NotFoundExceptionInterface | ContainerExceptionInterface $e) {

//        }

        return $this->redirectToRoute('app_home');
    }

    #[Route('/logout', name: "app_logout")]
    public function logout()
    {
        return;
    }
}
