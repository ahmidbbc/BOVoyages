<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class RegisterController
 * @package App\Controller
 * @Route("/register")
 */
class RegisterController extends AbstractController
{
    /**
     * @var Form
     */
    private $form;

    /**
     * @param $request
     * @return User
     */
    private function initForm($request)
    {
        $user = new User();

        $this->form = $this->createForm(RegisterType::class, $user);
        $this->form->handleRequest($request, $user);

        return $user;
    }

    /**
     * @param $role
     */
    private function saveUser($role)
    {
        $user = $this->form->getData();
        $user->setRole($role);
        dump($user);
        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();
    }

    /**
     * @Route("/client", name="register_client")
     * @param Request $request
     * @return Response
     */
    public function newClient(Request $request)
    {
        $user = $this->initForm($request);

        if ($this->form->isSubmitted() && $this->form->isValid()) {
            $this->saveUser(1);
            return $this->redirectToRoute("sales_index");
        }

        return $this->render('register/index.html.twig', [
            'title' => "Inscription",
            'registerForm' => $this->form->createView()
        ]);

    }

    /**
     * @Route("/admin", name="register_admin")
     * @param Request $request
     * @return Response
     */
    public function newAdmin(Request $request)
    {
        $user = $this->initForm($request);

        if ($this->form->isSubmitted() && $this->form->isValid()) {
            $this->saveUser(0);
            return $this->redirectToRoute("travel_index");
        }

        return $this->render('register/index.html.twig', [
            'title' => "Administrateur",
            'registerForm' => $this->form->createView()
        ]);

    }
}
