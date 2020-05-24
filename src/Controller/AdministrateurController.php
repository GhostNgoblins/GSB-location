<?php

namespace App\Controller;
use App\Entity\Appartement;
use App\Entity\Demandes;
use App\Entity\Personne;
use App\Entity\Proprietaire;
use App\Entity\Locataire;
use App\Entity\Client;
use App\Entity\Admin;
use App\Entity\Visite;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AdministrateurController extends AbstractController
{

    /**
     * @Route("/voirMonProfilAdmin", name="voirMonProfilAdmin")
     */
    public function voirMonProfilAdmin()
    {
        return $this->render('administrateur/profil.html.twig', [
            'controller_name' => 'AdministrateurController',
        ]);
    }

    /**
     * @Route("/voirLesUtilisateurs", name="voirLesUtilisateurs")
     */
    public function voirLesProprietaires()
    {
        $type = "adm";
        return $this->render('administrateur/listeUtilisateurs.html.twig', [
            "proprietaires" => $this -> getDoctrine() -> getRepository(Proprietaire::class) -> findAll(),
            "locataires" => $this -> getDoctrine() -> getRepository(Locataire::class) -> findAll(),
            "clients" => $this -> getDoctrine() -> getRepository(Client::class) -> findAll(),
            "administrateurs" => $this -> getDoctrine() -> getRepository(Personne::class) -> findBy(array('num_cpte_banque'=>0)),
        ]);
    }

    /**
     * @Route("/voirLesAppartements", name="voirLesAppartements")
     */
    public function voirLesAppartements()
    {
        $typeStudio = 'STUDIO' ;
        $typeF1 = 'F1' ;
        $typeF2 = 'F2' ;
        $typeF3 = 'F3' ;
        return $this->render('administrateur/listeAppartements.html.twig', [
            "studios" => $this -> getDoctrine() -> getRepository(Appartement::class) -> findBy(array('type' => "$typeStudio")),
            "f1s" => $this -> getDoctrine() -> getRepository(Appartement::class) -> findBy(array('type' =>"$typeF1")),
            "f2s" => $this -> getDoctrine() -> getRepository(Appartement::class) -> findBy(array('type' =>"$typeF2")),
            "f3s" => $this -> getDoctrine() -> getRepository(Appartement::class) -> findBy(array('type' =>"$typeF3")),
        ]);
    }

    /**
     * @Route("/voirLesInfosAppartements", name="voirLesInfosAppartements")
     */
    public function voirLesInfosAppartements()
    {
        $id=$_REQUEST['id'];
        $appartement=$this->getDoctrine()->getRepository(Appartement::class)->find($id);
        return $this->render('administrateur/infoAppartement.html.twig', [
            "appartement" =>$appartement,
        ]);
    }

    /**
     * @Route("/voirLesCotisations", name="voirLesCotisations")
     */
    public function voirLesCotisations()
    {
        return $this->render('administrateur/listeCotisations.html.twig', [
            "proprietaires" => $this -> getDoctrine() -> getRepository(Proprietaire::class) -> findAll(),
        ]);
    }

    /**
     * @Route("/voirLesInfosCotisations", name="voirLesInfosCotisations")
     */
    public function voirLesInfosCotisations()
    {
        $id = $_REQUEST['id'];
        $leProprietaire = $this -> getDoctrine() -> getRepository(Proprietaire::class) -> find($id);
        return $this->render('administrateur/infoCotisations.html.twig', [
              "proprietaire"=>$leProprietaire 
        ]);
    }

    /**
     * @Route("/voirLesDemandes", name="voirLesDemandes")
     */
    public function voirLesDemandes()
    {
        
        $typeStudio = 'STUDIO' ;
        $typeF1 = 'F1' ;
        $typeF2 = 'F2' ;
        $typeF3 = 'F3' ;
        return $this->render('administrateur/listeDemandes.html.twig', [
        "demandes" => $this -> getDoctrine() -> getRepository(Demandes::class) -> findAll(),
        ]);
    }

    /**
     * @Route("/voirLesVisites", name="voirLesVisites")
     */
    public function voirLesVisites()
    {
        return $this->render('administrateur/listeVisites.html.twig', [
            "visites" => $this -> getDoctrine() -> getRepository(Visite::class) -> findAll(),
        ]);
    }

    /**
     * @Route("/demandeInscriptionAdmin", name="demandeInscriptionAdmin")
     */
    public function demandeInscriptionAdmin()
    {
        return $this->render('administrateur/forumlaireInscriptionAdmin.html.twig', [
            'controller_name' => 'AdministrateurController',
        ]);
    }

    /**
     * @Route("/valideInscriptionAdmin", name="valideInscriptionAdmin")
     */
    public function valideInscriptionAdmin(UserPasswordEncoderInterface $encoder)
    {
        $email = $_REQUEST['email']; 
        $nom = $_REQUEST['nom'];
        $prenom = $_REQUEST['prenom'];
        $dateNaiss = $_REQUEST['dateNaiss'];
        $adresse = $_REQUEST['adresse'];
        $codePostal = $_REQUEST['codePostal'];
        $ville = $_REQUEST['ville'];
        $tel = $_REQUEST['numTel'];
        $numTelBanque = 0;
        $numCptEnBanque = 0;
        $login = $_REQUEST['login'];
        $motDePasse = $_REQUEST['motDePasse'];
        $type = 'adm';

        if($email && $nom && $prenom && $dateNaiss && $adresse && $codePostal && $ville && $tel  && $login && $motDePasse)
        {
            $utilisateur = $this -> getDoctrine() -> getRepository(Personne::Class) -> findBy(array('login'=>'$login'));
            if($utilisateur == NULL)
            {
                    $dateNaiss = new \DateTime("$dateNaiss 00:00:00");
                    $user = new Admin($nom,$prenom,$adresse,$ville,$codePostal,$tel,$dateNaiss,$login,$motDePasse,$numCptEnBanque,$email,$numTelBanque);
                    $entityManager = $this -> getDoctrine() -> getManager();
                    $entityManager -> persist($user);
                    $entityManager -> flush();
                    $encoded = $encoder->encodePassword($user, $motDePasse);
                    $user = $this -> getDoctrine() -> getRepository(Admin::class) -> findOneBy(array('login'=>"$login")) -> setPassword($encoded);
                 
                $entityManager = $this -> getDoctrine() -> getManager();
                $entityManager -> persist($user);
                $entityManager -> flush(); // met à jour la base de donnée
                return $this->render('administrateur/inscriptionSuccess.html.twig', [
                    'controller_name' => 'connexionController',
                ]);
            }
            else
            {   
                echo "login existant";
                return $this->render('administrateur/forumlaireInscriptionAdmin.html.twig', [
                    'controller_name' => 'inscriptionController',
                ]);
            } 
        }
        else
        {
        echo "un champs est vide...";
        return $this->render('administrateur/forumlaireInscriptionAdmin.html.twig', [
            'controller_name' => 'inscriptionController',
        ]);
        }
    }

    /**
     * @Route("/valideModificationAdmin", name="valideModificationAdmin")
     */
    public function valideModificationAdmin()
    {
        $login = $_REQUEST['login']; 
        $email = $_REQUEST['email']; 
        $nom = $_REQUEST['nom'];
        $prenom = $_REQUEST['prenom'];
        $adresse = $_REQUEST['adresse'];
        $codePostal = $_REQUEST['codePostal'];
        $ville = $_REQUEST['ville'];
        $tel = $_REQUEST['numTel'];
        if ($email&&$nom&&$prenom&&$adresse&&$codePostal&&$ville&&$tel){
            $emailProprietaire = $this->getDoctrine()->getRepository(Personne::class)->findOneBy(array('login'=>"$login"))->setEmail($email);
            $nomProprietaire = $this->getDoctrine()->getRepository(Personne::class)->findOneBy(array('login'=>"$login"))->setNomPe($nom);
            $prenomProprietaire = $this->getDoctrine()->getRepository(Personne::class)->findOneBy(array('login'=>"$login"))->setPrenomPe($prenom);
            $adresseProprietaire = $this->getDoctrine()->getRepository(Personne::class)->findOneBy(array('login'=>"$login"))->setAdressePe($adresse);
            $codePostalProprietaire = $this->getDoctrine()->getRepository(Personne::class)->findOneBy(array('login'=>"$login"))->setCodePostal($codePostal);
            $villeProprietaire = $this->getDoctrine()->getRepository(Personne::class)->findOneBy(array('login'=>"$login"))->setNomVille($ville);
            $telProprietaire = $this->getDoctrine()->getRepository(Personne::class)->findOneBy(array('login'=>"$login"))->setTelephonePe($tel);
            //faire les modifications dans la bdd
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->render('administrateur/profil.html.twig');
        }
        print("Champs vides");
        return $this->render('administrateur/profil.html.twig');
    }

    /**
     * @Route("/supprimerAppartement", name="supprimerAppartement")
     */
    public function supprimerAppartement()
    {
        $typeStudio = 'STUDIO' ;
        $typeF1 = 'F1' ;
        $typeF2 = 'F2' ;
        $typeF3 = 'F3' ;
        $nom = $_REQUEST['nom'];
        $appart = $this -> getDoctrine() -> getRepository(Appartement::Class) -> findOneBy(array('nom'=>"$nom"));
        $entityManager = $this -> getDoctrine() -> getManager();
        $entityManager -> remove($appart);
        $entityManager -> flush();
        return $this->render('administrateur/listeAppartements.html.twig', [
            'controller_name' => 'DefaultController',
            "studios" => $this -> getDoctrine() -> getRepository(Appartement::class) -> findBy(array('type' => "$typeStudio")),
            "f1s" => $this -> getDoctrine() -> getRepository(Appartement::class) -> findBy(array('type' =>"$typeF1")),
            "f2s" => $this -> getDoctrine() -> getRepository(Appartement::class) -> findBy(array('type' =>"$typeF2")),
            "f3s" => $this -> getDoctrine() -> getRepository(Appartement::class) -> findBy(array('type' =>"$typeF3")),
        
        ]); 
    }
    
}
