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

        $this->PlayAllHands();

        return $this->render('play/index.html.twig', [
            'controller_name' => 'PlayController',
        ]);
    }

private function PlayAllHands()
{
    $em = $this->getDoctrine()->getManager();
    $conn = $em->getConnection();
    $sql = 'select distinct hand_round from Hands';
    $stmt = $conn->query($sql);

      $player1Score=0;
    $player2Score=0;
    while ($row = $stmt->fetch()) {
        $ens = $em->getRepository(Hands::class)
          ->findBy(
             array('HandRound'=> $row['hand_round']), 
             array()
           );
        if(strlen($ens[0]->getCards())>0 && strlen($ens[1]->getCards())>0)
        {
        $player1Rank =$this->evaluateCards($ens[0]->getCards());
        $player2Rank =$this->evaluateCards($ens[1]->getCards());
       
        if ($player1Rank>$player2Rank)
            $player1Score++;
        if ($player2Rank>$player1Rank)
            $player2Score++;
        }
    }
    echo ("Player 1 score :".$player1Score);
    echo ("   Player 2 score :".$player2Score);
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
