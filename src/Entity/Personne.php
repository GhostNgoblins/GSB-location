<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Id\AssignedGenerator;

/**
 * @ORM\Entity()
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\DiscriminatorMap({
 * "per"="Personne",
 * "cli" = "Client", 
 * "adm" = "Admin",
 * "pro" = "Proprietaire",
 * "loc" = "Locataire"
 * })
 * 
 */

 //@ORM\Table(name="personne")
abstract class Personne implements UserInterface
{
    private $roles;

    /**
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

   

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $num_cpte_banque;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nom_Pe;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $prenom_Pe;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $adresse_Pe;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $telephone_Pe;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $code_postal;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nom_ville;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $login;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $mdp;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $anniv;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $tel_banque;

    


    public function __construct($nom,$prenom,$adresse,$ville,$cp,$tel,$anniv,$login,$mdp,$rib,$email,$telB){
        $this->nom_Pe = $nom;
        $this->prenom_Pe = $prenom;
        $this->adresse_Pe = $adresse;
        $this->nom_ville = $ville ;
        $this->code_postal =$cp;
        $this->telephone_Pe = $tel;
        $this->anniv = $anniv;
        $this->login = $login;
        $this->mdp =$mdp;
        $this->num_cpte_banque =$rib;
        $this->email = $email;
        $this->tel_banque = $telB; 
    }
    

    

    public function getId(): ?int
    {
        return $this->id;
    }



    

    public function getNumCpteBanque(): ?string
    {
        return $this->num_cpte_banque;
    }

    public function setNumCpteBanque(string $num_cpte_banque): self
    {
        $this->num_cpte_banque = $num_cpte_banque;

        return $this;
    }

    public function getNomPe(): ?string
    {
        return $this->nom_Pe;
    }

    public function setNomPe(?string $nom_Pe): self
    {
        $this->nom_Pe = $nom_Pe;

        return $this;
    }

    public function getPrenomPe(): ?string
    {
        return $this->prenom_Pe;
    }

    public function setPrenomPe(?string $prenom_Pe): self
    {
        $this->prenom_Pe = $prenom_Pe;

        return $this;
    }

    public function getAdressePe(): ?string
    {
        return $this->adresse_Pe;
    }

    public function setAdressePe(?string $adresse_Pe): self
    {
        $this->adresse_Pe = $adresse_Pe;

        return $this;
    }

    public function getTelephonePe(): ?int
    {
        return $this->telephone_Pe;
    }

    public function setTelephonePe(?int $telephone_Pe): self
    {
        $this->telephone_Pe = $telephone_Pe;

        return $this;
    }

    public function getCodePostal(): ?int
    {
        return $this->code_postal;
    }

    public function setCodePostal(?int $code_postal): self
    {
        $this->code_postal = $code_postal;

        return $this;
    }

    public function getNomVille(): ?string
    {
        return $this->nom_ville;
    }

    public function setNomVille(?string $nom_ville): self
    {
        $this->nom_ville = $nom_ville;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->login;
    }

    public function setUsername(string $login): self
    {
        $this->login = $login;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->mdp;
    }

    public function setPassword(string $mdp): self
    {
        $this->mdp = $mdp;

        return $this;
    }

    public function getAnniv(): ?\DateTimeInterface
    {
        return $this->anniv;
    }

    public function setAnniv(?\DateTimeInterface $anniv): self
    {
        $this->anniv = $anniv;

        return $this;
    }

    public function getTelBanque(): ?int
    {
        return $this->tel_banque;
    }

    public function setTelBanque(?int $tel_banque): self
    {
        $this->tel_banque = $tel_banque;

        return $this;
    }

    public function getSalt()
    {
    
    }

    public function getRoles():array
    {
        $this->roles[] = 'ROLE_USER' ;
        return array_unique($this->roles);
    }

    public function eraseCredentials()
    {}


}
