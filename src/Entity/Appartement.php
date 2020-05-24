<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AppartementRepository")
 */
class Appartement
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
    private $nom;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $type;

    /**
     * @ORM\Column(type="float")
     */
    private $prixLoc;

    /**
     * @ORM\Column(type="float")
     */
    private $prixCharges;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $rue;

    /**
     * @ORM\Column(type="integer")
     */
    private $arrondissement;

    /**
     * @ORM\Column(type="integer")
     */
    private $etage;

    /**
     * @ORM\Column(type="boolean")
     */
    private $ascenseur;

    /**
     * @ORM\Column(type="boolean")
     */
    private $preavis;

    /**
     * @ORM\Column(type="date")
     */
    private $dateLibre;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Proprietaire", inversedBy="appartements")
     * @ORM\JoinColumn(nullable=true)
     */
    private $proprietaire;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Admin", inversedBy="appartements")
     */
    private $administrateur;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Locataire",mappedBy="appartements",cascade={"persist","remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $locataire;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Visite", mappedBy="appartement", cascade={"remove"})
     */
    private $visites;

   



    public function __construct($nom,$type,$prixLoc,$prixCharges,$rue,$arrondissement,$etage,$ascenseur,$preavis,$dateLibre,$proprietaire)
    {
        $this->nom = $nom ;
        $this->type = $type ;
        $this->prixLoc = $prixLoc ;
        $this->prixCharges = $prixCharges ;
        $this->rue = $rue ;
        $this->arrondissement = $arrondissement ;
        $this->etage = $etage ;
        $this->ascenseur = $ascenseur ;
        $this->preavis = $preavis ;
        $this->dateLibre = $dateLibre ;
        $this->proprietaire = $proprietaire ;
        $this->locataire = null ;
        $this->administrateur = new ArrayCollection();
        $this->visites = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
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

    public function getPrixLoc(): ?float
    {
        return $this->prixLoc;
    }

    public function setPrixLoc(float $prixLoc): self
    {
        $this->prixLoc = $prixLoc;

        return $this;
    }

    public function getPrixCharges(): ?float
    {
        return $this->prixCharges;
    }

    public function setPrixCharges(float $prixCharges): self
    {
        $this->prixCharges = $prixCharges;

        return $this;
    }

    public function getRue(): ?string
    {
        return $this->rue;
    }

    public function setRue(string $rue): self
    {
        $this->rue = $rue;

        return $this;
    }

    public function getArrondissement(): ?int
    {
        return $this->arrondissement;
    }

    public function setArrondissement(int $arrondissement): self
    {
        $this->arrondissement = $arrondissement;

        return $this;
    }

    public function getEtage(): ?int
    {
        return $this->etage;
    }

    public function setEtage(int $etage): self
    {
        $this->etage = $etage;

        return $this;
    }

    public function getAscenseur(): ?bool
    {
        return $this->ascenseur;
    }

    public function setAscenseur(bool $ascenseur): self
    {
        $this->ascenseur = $ascenseur;

        return $this;
    }

    public function getPreavis(): ?bool
    {
        return $this->preavis;
    }

    public function setPreavis(bool $preavis): self
    {
        $this->preavis = $preavis;

        return $this;
    }

    public function getDateLibre(): ?\DateTimeInterface
    {
        return $this->dateLibre;
    }

    public function setDateLibre(\DateTimeInterface $dateLibre): self
    {
        $this->dateLibre = $dateLibre;

        return $this;
    }

    public function getProprietaire(): ?Proprietaire
    {
        return $this->proprietaire;
    }

    public function setProprietaire(?Proprietaire $proprietaire): self
    {
        $this->proprietaire = $proprietaire;

        return $this;
    }

    /**
     * @return Collection|Admin[]
     */
    public function getAdministrateur(): Collection
    {
        return $this->administrateur;
    }

    public function addAdministrateur(Admin $administrateur): self
    {
        if (!$this->administrateur->contains($administrateur)) {
            $this->administrateur[] = $administrateur;
        }

        return $this;
    }

    public function removeAdministrateur(Admin $administrateur): self
    {
        if ($this->administrateur->contains($administrateur)) {
            $this->administrateur->removeElement($administrateur);
        }

        return $this;
    }

    public function getLocataire(): ?Locataire
    {
        return $this->locataire;
    }

    public function setLocataire(Locataire $locataire): self
    {
        $this->locataire = $locataire;

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
            $visite->setAppartement($this);
        }

        return $this;
    }

    public function removeVisite(Visite $visite): self
    {
        if ($this->visites->contains($visite)) {
            $this->visites->removeElement($visite);
            // set the owning side to null (unless already changed)
            if ($visite->getAppartement() === $this) {
                $visite->setAppartement(null);
            }
        }

        return $this;
    }

    

    
}
