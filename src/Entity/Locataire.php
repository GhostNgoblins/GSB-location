<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LocataireRepository")
 */
class Locataire extends Personne
{
    
    private $type = 'loc';

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Banque", inversedBy="locataire")
     */
    private $banque;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Appartement", inversedBy="locataire")
     */
    private $appartements;

    public function __construct($nom,$prenom,$adresse,$ville,$cp,$tel,$anniv,$login,$mdp,$rib,$email,$telB,$idB,$idA)
    {
        parent::__construct($nom,$prenom,$adresse,$ville,$cp,$tel,$anniv,$login,$mdp,$rib,$email,$telB);
        $this->banque =$idB ;
        $this->appartements = $idA;
        
    }



    public function getType(){
        return $this->type;
    }

    public function getBanque(): ?Banque
    {
        return $this->banque;
    }

    public function setBanque(?Banque $banque): self
    {
        $this->banque = $banque;

        return $this;
    }

    public function getAppartements(): ?Appartement
    {
        return $this->appartements;
    }

   

}
