<?php

namespace App\Controller;

use App\Entity\Hands;
use App\Lib\Constants;
use App\Lib\FiveCard;


use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PlayController extends AbstractController
{
    private $FiveCardRank;

    /**
     * @Route("/play", name="play")
     */
    public function index()
    {
        if(!isset($this->FiveCardRank))
            $this->FiveCardRank = new FiveCard();

        $this->PlayFirstHand();

        return $this->render('play/index.html.twig', [
            'controller_name' => 'PlayController',
        ]);
    }

    private function PlayFirstHand()
    {
        $em = $this->getDoctrine()->getManager();
        $ens = $em->getRepository(Hands::class)
          ->findBy(
             array('HandRound'=> '11'), 
             array()
           );

       $Player_1_Cards=explode(' ',$ens[0]->getCards());
       $Player_2_Cards=$ens[1]->getCards();
      
       $player1Rank =$this->evaluateCards($ens[0]->getCards());
       $player2Rank =$this->evaluateCards($ens[1]->getCards());
       
       if ($player1Rank>$player2Rank)
           echo ("Player 1 win : ". $ens[0]->getCards(). " rank ".$player1Rank . " against : ". $ens[1]->getCards() ."  rank ".$player2Rank);
        if ($player2Rank>$player1Rank)
           echo ("Player 2 win : ". $ens[1]->getCards(). " rank ".$player2Rank . " against : ". $ens[0]->getCards() ."  rank ".$player1Rank);
    }


    private function evaluateCards($cards)
    {
        return ($this->_rank($cards)); 
    }

    private function _rank($hand)
    {
        return $this->FiveCardRank->evaluate($hand);
    }

}
