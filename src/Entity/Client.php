<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ClientRepository")
 */
class Client extends Personne
{

    private $type = 'cli';

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Demandes", mappedBy="client",cascade={"remove"})
     */
    private $demandes;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Visite", mappedBy="client",cascade={"remove"})
     */
    private $visites;

    public function __construct($nom,$prenom,$adresse,$ville,$cp,$tel,$anniv,$login,$mdp,$rib,$email,$telB)
    {
        parent::__construct($nom,$prenom,$adresse,$ville,$cp,$tel,$anniv,$login,$mdp,$rib,$email,$telB);
        $this->demandes = new ArrayCollection();
        $this->visites = new ArrayCollection();
    }

   

    public function getType(){
        return $this->type;
    }

    /**
     * @return Collection|Demandes[]
     */
    public function getDemandes(): Collection
    {
        return $this->demandes;
    }

    public function addDemande(Demandes $demande): self
    {
        if (!$this->demandes->contains($demande)) {
            $this->demandes[] = $demande;
            $demande->setClient($this);
        }

        return $this;
    }

    public function removeDemande(Demandes $demande): self
    {
        if ($this->demandes->contains($demande)) {
            $this->demandes->removeElement($demande);
            // set the owning side to null (unless already changed)
            if ($demande->getClient() === $this) {
                $demande->setClient(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Visite[]
     */
    public function getVisites(): Collection
    {
        return $this->visites;
    }

    public function addVisite(Visite $visite): self
    {
        if (!$this->visites->contains($visite)) {
            $this->visites[] = $visite;
            $visite->setClient($this);
        }

        return $this;
    }

    public function removeVisite(Visite $visite): self
    {
        if ($this->visites->contains($visite)) {
            $this->visites->removeElement($visite);
            // set the owning side to null (unless already changed)
            if ($visite->getClient() === $this) {
                $visite->setClient(null);
            }
        }

        return $this;
    }
}
