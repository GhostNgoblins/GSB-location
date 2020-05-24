<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DemandesRepository")
 */
class Demandes
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    /**
     * @ORM\Column(type="date")
     */
    private $dateDepart;

    /**
     * @ORM\Column(type="date")
     */
    private $dateArrivee;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Client", inversedBy="demandes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $client;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Arrondissement", inversedBy="demandes")
     */
    private $arrondissements;

    public function __construct($type,$datearr,$datedep,$id)
    {
        //constructeur de la classe demande
        $this->type =$type;
        $this->dateArrivee = $datearr ;
        $this->dateDepart = $datedep;
        $this->client= $id;
        $this->arrondissements = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getDateDepart(): ?\DateTimeInterface
    {
        return $this->dateDepart;
    }

    public function setDateDepart(\DateTimeInterface $dateDepart): self
    {
        $this->dateDepart = $dateDepart;

        return $this;
    }

    public function getDateArrivee(): ?\DateTimeInterface
    {
        return $this->dateArrivee;
    }

    public function setDateArrivee(\DateTimeInterface $dateArrivee): self
    {
        $this->dateArrivee = $dateArrivee;

        return $this;
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

    /**
     * @return Collection|Arrondissement[]
     */
    public function getArrondissements(): Collection
    {
        return $this->arrondissements;
    }

    public function addArrondissement(Arrondissement $arrondissement): self
    {
        if (!$this->arrondissements->contains($arrondissement)) {
            $this->arrondissements[] = $arrondissement;
        }

        return $this;
    }

    public function removeArrondissement(Arrondissement $arrondissement): self
    {
        if ($this->arrondissements->contains($arrondissement)) {
            $this->arrondissements->removeElement($arrondissement);
        }

        return $this;
    }
}
