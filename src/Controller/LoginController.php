<?php

namespace App\Controller;

use App\Form\LoginType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class LoginController extends AbstractController
{
    /**
     * @Route("/login", name="login")
     * @param Request $request
     * @param UserRepository $userRepository
     * @param SessionInterface $session
     * @return Response
     */
    public function index(Request $request, UserRepository $userRepository, SessionInterface $session)
    {

        $form = $this->createForm(LoginType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $loginData = $form->getData();
            $user = $userRepository->findOneBy([
                "email" => $loginData["login"],
                "password" => $loginData["password"]
            ]);
            if ($user) {
                $session->set("user", $user);
                if ($user->getRole() == 0) {
                    $route = "travel_index";
                } else {
                    $route = "sales_index";
                }
                return $this->redirectToRoute($route);
            }
        }

        return $this->render('login/index.html.twig', [
            'loginForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/logout", name="logout")
     * @param SessionInterface $session
     * @return RedirectResponse
     */
    public function logout(SessionInterface $session)
    {
        $session->set("user", null);
        return $this->redirectToRoute("sales_index");
    }
}
