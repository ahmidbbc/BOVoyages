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
     * @var SessionInterface
     */
    private $session;


    /**
     * SalesController constructor.
     */
    public function __construct(EntityManagerInterface $em, SessionInterface $session)
    {
        $this->em = $em;
        $this->session = $session;
    }


    /**
     * @Route("/sales", name="sales_index")
     */
    public function index()
    {
        $client = $this->session->get('user', null);

        $salesRepo= $this->em->getRepository(Travel::class);
        $salesList = $salesRepo->getTravelList();

        return $this->render('sales/index.html.twig', [
            'salesList' => $salesList,
            'client' => $client
        ]);
    }

    /**
     * @Route("/new/{id}", name="sales_new")
     */
    public function new(Request $request, Travel $travel)
    {

       $client = $this->session->get('user', null);

        if(!$client){

            return $this->redirectToRoute('login');
        }

        $form = $this->createForm(SalesType::class, $travel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $travel->setClient($client);
            $travel->setStatus(1);

            $this->em->persist($travel);
            $this->em->flush();

            return $this->redirectToRoute('sales_index', [
            'client' => $client
            ]);
        }

        return $this->render('sales/new.html.twig', [
            'travel' => $travel,
            'form' => $form->createView(),
            'client' => $client
        ]);
    }
}
