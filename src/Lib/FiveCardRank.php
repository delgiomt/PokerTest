<?php
namespace App\Lib;

use App\Lib\Constants;

class FiveCard
{
    private $rank, $flushRank, $face, $flush, $suit;
    /**
     * Constructor
     */
    public function __construct($generate=true)
    {
        if ($generate) {
            $this->generateDeck();
            $this->generateRankings();
        }
    }


    private function generateDeck()
    {
        $this->face = array();
        $this->flush = array();
        $this->suit = array();
        $face = array(
            Constants::ACE_FIVE, Constants::KING_FIVE, Constants::QUEEN_FIVE, Constants::JACK_FIVE,
            Constants::TEN_FIVE, Constants::NINE_FIVE, Constants::EIGHT_FIVE, Constants::SEVEN_FIVE,
            Constants::SIX_FIVE, Constants::FIVE_FIVE, Constants::FOUR_FIVE, Constants::THREE_FIVE,
            Constants::TWO_FIVE
        );
        $faceflush = array(
            Constants::ACE_FLUSH, Constants::KING_FLUSH, Constants::QUEEN_FLUSH, Constants::JACK_FLUSH,
            Constants::TEN_FLUSH, Constants::NINE_FLUSH, Constants::EIGHT_FLUSH, Constants::SEVEN_FLUSH,
            Constants::SIX_FLUSH, Constants::FIVE_FLUSH, Constants::FOUR_FLUSH, Constants::THREE_FLUSH,
            Constants::TWO_FLUSH
        );
        for ($n=0; $n<13; $n++) {
            $this->suit[4*$n]=Constants::SPADE;
            $this->suit[4*$n+1]=Constants::HEART;
            $this->suit[4*$n+2]=Constants::DIAMOND;
            $this->suit[4*$n+3]=Constants::CLUB;
            $this->face[4*$n]=$face[$n];
            $this->face[4*$n+1]=$face[$n];
            $this->face[4*$n+2]=$face[$n];
            $this->face[4*$n+3]=$face[$n];
            $this->flush[4*$n]=$faceflush[$n];
            $this->flush[4*$n+1]=$faceflush[$n];
            $this->flush[4*$n+2]=$faceflush[$n];
            $this->flush[4*$n+3]=$faceflush[$n];
        }
    }
    private function generateRankings()
    {
        $this->rank = array(Constants::MAX_FIVE_NONFLUSH_KEY_INT+1);
        $this->flushRank = array(Constants::MAX_FLUSH_KEY_INT+1);
        $face = array(
            Constants::TWO_FIVE, Constants::THREE_FIVE, Constants::FOUR_FIVE, Constants::FIVE_FIVE,
            Constants::SIX_FIVE, Constants::SEVEN_FIVE, Constants::EIGHT_FIVE, Constants::NINE_FIVE,
            Constants::TEN_FIVE, Constants::JACK_FIVE, Constants::QUEEN_FIVE, Constants::KING_FIVE,
            Constants::ACE_FIVE
        );
        $faceflush = array(
            Constants::TWO_FLUSH, Constants::THREE_FLUSH, Constants::FOUR_FLUSH, Constants::FIVE_FLUSH,
            Constants::SIX_FLUSH, Constants::SEVEN_FLUSH, Constants::EIGHT_FLUSH, Constants::NINE_FLUSH,
            Constants::TEN_FLUSH, Constants::JACK_FLUSH, Constants::QUEEN_FLUSH, Constants::KING_FLUSH,
            Constants::ACE_FLUSH
        );
        $n=1; // rank number
        for ($i=0; $i<Constants::MAX_FIVE_NONFLUSH_KEY_INT+1; $i++) {$this->rank[$i]=0;}
        for ($i=0; $i<Constants::MAX_FLUSH_KEY_INT+1; $i++) {$this->flushRank[$i]=0;}
        //high card
        for ($i=5; $i<=12; $i++) {
            for ($j=3; $j<=$i-1; $j++) {
                for ($k=2; $k<=$j-1; $k++) {
                    for ($l=1; $l<=$k-1; $l++) {
                        //no straights
                        for ($m=0; $m<=$l-1 && !($i-$m==4 || ($i==12 && $j==3 && $k==2 && $l==1 && $m==0)); $m++) {
                            $this->rank[$face[$i]+$face[$j]+$face[$k]+$face[$l]+$face[$m]]=$n;
                            $n++;}}}}}
        //pair
        for ($i=0; $i<=12; $i++) {
            for ($j=2; $j<=12; $j++) {
                for ($k=1; $k<=$j-1; $k++) {
                    for ($l=0; $l<=$k-1; $l++) {
                        if ($i!=$j && $i!=$k && $i!=$l) {
                            $this->rank[(2*$face[$i])+$face[$j]+$face[$k]+$face[$l]]=$n;
                            $n++;}}}}}
        //2pair
        for ($i=1; $i<=12; $i++) {
            for ($j=0; $j<=$i-1; $j++) {
                for ($k=0; $k<=12; $k++) {
                    //no fullhouse
                    if ($k!=$i && $k!=$j) {
                        $this->rank[(2*$face[$i])+(2*$face[$j])+$face[$k]]=$n;
                        $n++;}}}}
        //triple
        for ($i=0; $i<=12; $i++) {
            for ($j=1; $j<=12; $j++) {
                for ($k=0; $k<=$j-1; $k++) {
                    //$no quad
                    if ($i!=$j && $i!=$k) {
                        $this->rank[(3*$face[$i])+$face[$j]+$face[$k]]=$n;
                        $n++;}}}}
        //low straight nonflush
        $this->rank[$face[12]+$face[0]+$face[1]+$face[2]+$face[3]]=$n;
        $n++;
        //usual straight nonflush
        for ($i=0; $i<=8; $i++) {
            $this->rank[$face[$i]+$face[$i+1]+$face[$i+2]+$face[$i+3]+$face[$i+4]]=$n; $n++;}
        //flush not a straight
        for ($i=5; $i<=12; $i++) {
            for ($j=3; $j<=$i-1; $j++) {
                for ($k=2; $k<=$j-1; $k++) {
                    for ($l=1; $l<=$k-1; $l++) {
                        for ($m=0; $m<=$l-1; $m++) {
                            if (!($i-$m==4 || ($i==12 && $j==3 && $k==2 && $l==1 && $m==0))) {
                                $this->flushRank[$faceflush[$i]+$faceflush[$j]+$faceflush[$k]+
                                                $faceflush[$l]+$faceflush[$m]]=$n;
                                $n++;}}}}}}
        //full house
        for($i=0; $i<=12; $i++)
            for ($j=0; $j<=12; $j++) {
                if ($i!=$j) {
                    $this->rank[(3*$face[$i])+(2*$face[$j])]=$n;
                    $n++;}}
        //quad
        for ($i=0; $i<=12; $i++) {
            for ($j=0; $j<=12; $j++) {
                if ($i!=$j) {
                    $this->rank[(4*$face[$i])+$face[$j]]=$n;
                    $n++;}}}
        //low straight flush
        $this->flushRank[$faceflush[0]+$faceflush[1]+$faceflush[2]+$faceflush[3]+$faceflush[12]]=$n;
        $n++;
        //usual straight flush
        for ($i=0; $i<=8; $i++) {
            $this->flushRank[$faceflush[$i]+$faceflush[$i+1]+$faceflush[$i+2]+
                $faceflush[$i+3]+$faceflush[$i+4]]=$n;
            $n++;}
    }

    /**
     * Gets the numerical rank of a combination of 5 cards in either int or Card form
     */
    public function evaluateFive($card1, $card2, $card3, $card4, $card5)
    {
        $card1 = is_int($card1) ? $card1 : $card1->intVal();
        $card2 = is_int($card2) ? $card2 : $card2->intVal();
        $card3 = is_int($card3) ? $card3 : $card3->intVal();
        $card4 = is_int($card4) ? $card4 : $card4->intVal();
        $card5 = is_int($card5) ? $card5 : $card5->intVal();
        if( ($this->suit[$card1] == $this->suit[$card2]) &&
            ($this->suit[$card1] == $this->suit[$card3]) &&
            ($this->suit[$card1] == $this->suit[$card4]) &&
            ($this->suit[$card1] == $this->suit[$card5])){
            return $this->flushRank[
                $this->flush[$card1]+$this->flush[$card2]+
                $this->flush[$card3]+$this->flush[$card4]+
                $this->flush[$card5]
                ];
            } else {
            return $this->rank[
                $this->face[$card1]+$this->face[$card2]+
                $this->face[$card3]+$this->face[$card4]+
                $this->face[$card5]
                ];
            }
    }

    public function evaluate($cards)
    {
        if(is_string($cards))
            $cards = Card::parseHand($cards);
        if(count($cards) == 5)
            return $this->evaluateFive($cards[0], $cards[1], $cards[2], $cards[3], $cards[4]);
        else
            throw new \InvalidArgumentException("Must provide 5 cards");
    }
}