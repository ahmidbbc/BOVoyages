<?php

namespace App\Controller;

use App\Entity\Travel;
use App\Form\SalesType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class SalesController extends AbstractController
{

    /**
     * @var EntityManagerInterface
     */
    private $em;


    /**
     * SalesController constructor.
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }


    /**
     * @Route("/sales", name="sales_index")
     */
    public function index()
    {
        $salesRepo= $this->em->getRepository(Travel::class);
        $salesList = $salesRepo->getTravelList();

        return $this->render('sales/index.html.twig', [
            'salesList' => $salesList
        ]);
    }

    /**
     * @Route("/new/{id}", name="sales_new")
     */
    public function new(Request $request, Travel $travel, SessionInterface $session)
    {

       /* $client = $session->get('user', null);

        if(!$client){

            return $this->redirectToRoute('login', []);
        }*/

        $form = $this->createForm(SalesType::class, $travel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $travel->setClient($client);

            $this->em->persist($travel);
            $this->em->flush();

            return $this->redirectToRoute('sales_index');
        }

        return $this->render('sales/new.html.twig', [
            'travel' => $travel,
            'form' => $form->createView(),
        ]);
    }
}
