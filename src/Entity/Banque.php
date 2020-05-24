<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BanqueRepository")
 */
class Banque
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $rue;

    /**
     * @ORM\Column(type="integer")
     */
    private $codePostal;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $ville;

    /**
     * @ORM\Column(type="integer")
     */
    private $tel;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Locataire", mappedBy="banque")
     */
    private $locataire;

    public function __construct()
    {
        $this->locataire = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getCodePostal(): ?int
    {
        return $this->codePostal;
    }

    public function setCodePostal(int $codePostal): self
    {
        $this->codePostal = $codePostal;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    public function getTel(): ?int
    {
        return $this->tel;
    }

    public function setTel(int $tel): self
    {
        $this->tel = $tel;

        return $this;
    }

    /**
     * @return Collection|Locataire[]
     */
    public function getLocataire(): Collection
    {
        return $this->locataire;
    }

    public function addLocataire(Locataire $locataire): self
    {
        if (!$this->locataire->contains($locataire)) {
            $this->locataire[] = $locataire;
            $locataire->setBanque($this);
        }

        return $this;
    }

    public function removeLocataire(Locataire $locataire): self
    {
        if ($this->locataire->contains($locataire)) {
            $this->locataire->removeElement($locataire);
            // set the owning side to null (unless already changed)
            if ($locataire->getBanque() === $this) {
                $locataire->setBanque(null);
            }
        }

        return $this;
    }
}
