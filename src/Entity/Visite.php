<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\VisiteRepository")
 */
class Visite
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Client", inversedBy="visites")
     * @ORM\JoinColumn(nullable=true)
     */
    private $client;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Appartement", inversedBy="visites")
     * @ORM\JoinColumn(nullable=false)
     */
    private $appartement;

    /**
     * @ORM\Column(type="date")
     */
    private $dateVisite;

    
    public function __construct($id,$date,$appart){ //constructeur de visite
        $this->client = $id ;
        $this->appartement = $appart;
        $this->dateVisite=$date;
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }

    public function getAppartement(): ?Appartement
    {
        return $this->appartement;
    }

    public function setAppartement(?Appartement $appartement): self
    {
        $this->appartement = $appartement;

        return $this;
    }

    public function getDateVisite(): ?\DateTimeInterface
    {
        return $this->dateVisite;
    }

    public function setDateVisite(\DateTimeInterface $dateVisite): self
    {
        $this->dateVisite = $dateVisite;

        return $this;
    }
}
