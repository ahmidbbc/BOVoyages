<?php

namespace App\Controller;

use App\Entity\Travel;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class SalesController extends AbstractController
{
    /**
     * SalesController constructor.
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }


    /**
     * @Route("/sales", name="sales")
     */
    public function index()
    {
        $salesRepo= $this->em->getRepository(Travel::class);
        $salesList = $salesRepo->getTravelList();

        return $this->render('sales/index.html.twig', [
            'salesList' => $salesList
        ]);
    }
}
