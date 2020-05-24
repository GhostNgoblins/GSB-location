<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProprietaireRepository")
 */
class Proprietaire extends Personne
{

    private $type = 'pro';

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Appartement", mappedBy="proprietaire", cascade={"remove"})
     */
    private $appartements;

    public function __construct($nom,$prenom,$adresse,$ville,$cp,$tel,$anniv,$login,$mdp,$rib,$email,$telB)
    {
        parent::__construct($nom,$prenom,$adresse,$ville,$cp,$tel,$anniv,$login,$mdp,$rib,$email,$telB);
        $this->appartements = new ArrayCollection();
    }

    public function getType(){
        return $this->type;
    }

    /**
     * @return Collection|Appartement[]
     */
    public function getAppartements(): Collection
    {
        return $this->appartements;
    }

    public function addAppartement(Appartement $appartement): self
    {
        if (!$this->appartements->contains($appartement)) {
            $this->appartements[] = $appartement;
            $appartement->setProprietaire($this);
        }

        return $this;
    }

    public function removeAppartement(Appartement $appartement): self
    {
        if ($this->appartements->contains($appartement)) {
            $this->appartements->removeElement($appartement);
            // set the owning side to null (unless already changed)
            if ($appartement->getProprietaire() === $this) {
                $appartement->setProprietaire(null);
            }
        }

        return $this;
    }
}
