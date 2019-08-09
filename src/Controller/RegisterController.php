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
     */
    private function initForm($request)
    {
        $user = new User();

        $this->form = $this->createForm(RegisterType::class, $user);
        $this->form->handleRequest($request, $user);
    }

    /**
     * @param $role
     * @return bool
     */
    private function saveUser($role)
    {
        $user = $this->form->getData();
        $repository = $this->getDoctrine()->getRepository(User::class);
        $exist = $repository->findOneBy([ "email" => $user->getEmail() ]);
        if (!$exist) {
            $user->setRole($role);
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            $success = true;
        } else {
            $this->addFlash("error", "Cet email est déjà utilisé");
            $success = false;
        }
        return $success;
    }

    /**
     * @Route("/client", name="register_client")
     * @param Request $request
     * @return Response
     */
    public function newClient(Request $request)
    {
        $this->initForm($request);

        if ($this->form->isSubmitted() && $this->form->isValid()) {
            if ($this->saveUser(1)) {
                return $this->redirectToRoute("sales_index");
            }
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
        $this->initForm($request);

        if ($this->form->isSubmitted() && $this->form->isValid()) {
            if ($this->saveUser(0)) {
                return $this->redirectToRoute("travel_index");
            }
        }

        return $this->render('register/index.html.twig', [
            'title' => "Administrateur",
            'registerForm' => $this->form->createView()
        ]);

    }
}
