<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\HandsRepository")
 */
class Hands
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $HandRound;

    /**
     * @ORM\Column(type="integer")
     */
    private $PlayerId;

    /**
     * @ORM\Column(type="string", length=14)
     */
    private $Cards;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $Rank;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHandRound(): ?int
    {
        return $this->HandRound;
    }

    public function setHandRound(int $HandRound): self
    {
        $this->HandRound = $HandRound;

        return $this;
    }

    public function getPlayerId(): ?int
    {
        return $this->PlayerId;
    }

    public function setPlayerId(int $PlayerId): self
    {
        $this->PlayerId = $PlayerId;

        return $this;
    }

    public function getCards(): ?string
    {
        return $this->Cards;
    }

    public function setCards(string $Cards): self
    {
        $this->Cards = $Cards;

        return $this;
    }

    public function getWinnerdId(): ?int
    {
        return $this->WinnerdId;
    }

    public function setWinnerdId(int $WinnerdId): self
    {
        $this->WinnerdId = $WinnerdId;

        return $this;
    }
}
