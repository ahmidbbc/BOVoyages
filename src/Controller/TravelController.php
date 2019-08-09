<?php

namespace App\Controller;

use App\Entity\Travel;
use App\Form\TravelType;
use App\Repository\TravelRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/travel")
 */
class TravelController extends AbstractController
{
    /**
     * @var SessionInterface
     */
    private $session;

    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * TravelController constructor.
     */
    public function __construct(EntityManagerInterface $em, SessionInterface $session)
    {
        $this->session = $session;
        $this->em = $em;
    }

    /**
     * @Route("/admin", name="travel_index", methods={"GET"})
     */
    public function index(TravelRepository $travelRepository): Response
    {

        $client = $this->session->get('user', null);

        $statusList = [
            "A la vente",
            "Réservé",
            "Attente paiment",
            "Controle disponibilité",
            "Accepté",
            "Refusé"
        ];

        return $this->render('travel/index.html.twig', [
            'travels' => $travelRepository->findAll(),
            'statusList' => $statusList,
            'client' => $client
        ]);
    }

    /**
     * @Route("/sales", name="sales_List")
     */
    public function salesList(TravelRepository $repository)
    {
        $client = $this->session->get('user', null);


        $statusList = [
            "A la vente",
            "Réservé",
            "Attente paiment",
            "Controle disponibilité",
            "Accepté",
            "Refusé"
        ];

        return $this->render('travel/sales.html.twig', [
            'salesList' => $repository->getSales(),
            'statusList' => $statusList,
            'client' => $client
        ]);

    }

    /**
     * @Route("/new", name="travel_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $client = $this->session->get('user', null);

        $travel = new Travel();
        $form = $this->createForm(TravelType::class, $travel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($travel);
            $entityManager->flush();

            return $this->redirectToRoute('travel_index');
        }

        return $this->render('travel/new.html.twig', [
            'travel' => $travel,
            'form' => $form->createView(),
            'client' => $client
        ]);
    }

    /**
     * @Route("/{id}", name="travel_show", methods={"GET"})
     */
    public function show(Travel $travel): Response
    {
        $client = $this->session->get('user', null);

        return $this->render('travel/show.html.twig', [
            'travel' => $travel,
            'client' => $client
        ]);
    }

    /**
     * @Route("/{id}/edit", name="travel_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Travel $travel): Response
    {
        $client = $this->session->get('user', null);

        $form = $this->createForm(TravelType::class, $travel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('travel_index');
        }

        return $this->render('travel/edit.html.twig', [
            'travel' => $travel,
            'form' => $form->createView(),
            'client' => $client
        ]);
    }

    /**
     * @Route("/{id}", name="travel_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Travel $travel): Response
    {
        if ($this->isCsrfTokenValid('delete'.$travel->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($travel);
            $entityManager->flush();
        }

        return $this->redirectToRoute('travel_index');
    }

    /**
     * @Route("/update/{id}/{status}", name="update")
     */
    public function updateSale(Request $request, Travel $travel)
    {
        $client = $this->session->get('user', null);

        $status =  filter_input(INPUT_GET, 'status', FILTER_SANITIZE_STRING);
        $sale = $travel->setStatus($status);

        $form = $this->createForm(TravelType::class, $travel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('travel_index');
        }

    }

}
