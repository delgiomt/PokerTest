<?php

namespace App\Service;

use Psr\Log\LoggerInterface;
use App\Entity\Hands;
use Doctrine\ORM\EntityManagerInterface;


class HandsService 
{
    private $logger;
    private $em;

    public function __construct(LoggerInterface $logger,EntityManagerInterface $em) 
    {
        $this->logger = $logger;
        $this->em = $em;
    }

    public function storeHands($txtFileContent) 
    {
        $this->deleteHandsTable();
        try {
            $responseRows="";
            $ret = explode("\n", $txtFileContent);
            $entityManager= $this->em;
            $round=1;    
            foreach($ret as $hand) {
                $cards= explode(" ",$hand);
                if (count($cards)>0)
                    {
                        $hand= new Hands();
                        $hand->setHandRound($round);
                        $hand->setPlayerId(1);
                        $hand->setCards(implode(" ",array_slice($cards, 0,5)));
                        $entityManager->persist($hand);

                        $hand= new Hands();
                        $hand->setHandRound($round);
                        $hand->setPlayerId(2);
                        $hand->setCards(implode(" ",array_slice($cards, 5,5)));
                        $entityManager->persist($hand);
                    }
                $round++;
               // if ($round>=4) {break;}   // for test porpouse
            }
            $entityManager->flush();
            return $round;
        }
        catch (FileException $e){
            $this->logger->error('failed to save hands to the DB' . $e->getMessage());
            throw new FileException('failed to save hands to the DB');
        }
    }

    public function deleteHandsTable()
    {
        $entityManager= $this->em;
        $sql = 'delete  from  hands;';
        $connection = $entityManager->getConnection();
        $stmt = $connection->prepare($sql);
        $stmt->execute();
        $stmt->closeCursor();
    }

} 