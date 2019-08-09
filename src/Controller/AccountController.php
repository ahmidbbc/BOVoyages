<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\AccountType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class AccountController extends AbstractController
{
    /**
     * @Route("/account", name="account")
     * @param Request $request
     * @param SessionInterface $session
     * @return Response
     */
    public function index(Request $request, SessionInterface $session)
    {
        $user = new User();
        $user = $session->get("user");
        if (!$user) {
            return $this->redirectToRoute("sales_index");
        }

        $form = $this->createForm(AccountType::class, $user);

        if ($form->isSubmitted() && $form->isValid()) {
            // update user details
        }

        if ($user->getRole() == 1) {
            $title = "Votre compte";
        } else {
            $title = "Compte administrateur";
        }

        dump($user);

        return $this->render('account/index.html.twig', [
            "title" => $title,
            "user" => $user,
            "accountForm" => $form->createView(),
            "statusList" => [
                "A la vente",
                "Réservé",
                "Attente paiement",
                "Controle disponibilité",
                "Accepté",
                "Refusé"
            ]
        ]);
    }
}
