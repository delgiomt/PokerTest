<?php

namespace App\Controller;

use App\Entity\Hands;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HandsController extends AbstractController
{
    /**
     * @Route("/hands", name="create_hand")
     */
    public function createHand(): Response
    {
        $entityManager= $this->getDoctrine()->getManager();
        $hand= new Hands();
        $hand->setHandRound(1);
        $hand->setPlayerId(1);
        $hand->setCard("AA");
        $entityManager->persist($hand);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return new Response('Saved new hand with id '.$hand->getId());
    }



    public function index()
    {
        return $this->render('hands/index.html.twig', [
            'controller_name' => 'HandsController',
        ]);
    }
}
