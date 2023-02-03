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

class HomeController extends AbstractController
{
    private SessionInterface $session;
    private OktaApi $okta;
    private UserRepository $userRepository;

    public function __construct(RequestStack $requestStack, OktaApi $okta, UserRepository $repo)
    {
        $this->session = $requestStack->getSession();
        $this->okta = $okta;
        $this->userRepository = $repo;
    }

    #[Route('/', name: 'app_home', methods: "GET")]
    public function home(): Response
    {
        return $this->render('home.html.twig', [
            'controller_name' => 'HomeController',
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
            $user->setUserRole();
        }
        $user->setLastLogin(date("Y-m-d H:i:s", time()));
        $this->userRepository->save($user, true);

        $firewallName = 'main';

        // Manually authenticate the user
        $token = new UsernamePasswordToken($user, $firewallName, [$user->getUserRole()]);
        $this->container->get('security.token_storage')->setToken($token);
        $this->session->set('_security_' . $firewallName, serialize($token));

        return $this->redirectToRoute('app_home');
    }

    #[Route('/logout', name: "app_logout")]
    public function logout()
    {
        return;
    }
}
