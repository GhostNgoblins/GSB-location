<?php

namespace App\Controller;
use App\Entity\Personne;
use App\Entity\Appartement;
use App\Entity\Arrondissement;
use App\Entity\Proprietaire;
use App\Entity\Locataire;
use App\Entity\Client;
use App\Entity\Admin;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ProprietaireController extends AbstractController
{


    


/**
     * @Route("/appartements", name="appartements")
     */
    public function appartements()
    {
        return $this->render('proprietaire/appartements.html.twig', [
            'controller_name' => 'ProprietaireController',
        ]);
    }

    /**
     * @Route("/cotisations", name="cotisations")
     */
    public function cotisations()
    {
        return $this->render('proprietaire/cotisations.html.twig', [
            'controller_name' => 'ProprietaireController',
        ]);
    }

    /**
     * @Route("/voirMonAppartement", name="voirMonAppartement")
     */
    public function voirMonAppartement()
    {
        $id = $_REQUEST['id'];
        $appartement=$this->getDoctrine()->getRepository(Appartement::class)->find($id);
        return $this->render('proprietaire/infoAppartement.html.twig', [
            'appartement' => $appartement,
        ]);
    }

    /**
     * @Route("/nouvelAppartement", name="nouvelAppartement")
     */
    public function nouvelAppartement()
    {
        
        return $this->render('proprietaire/nouvelAppartement.html.twig', [
    
        ]);
    }

     /**
     * @Route("/ajouterAppartement", name="ajouterAppartement")
     */
    public function ajouterAppartement()
    {
        $id = $_REQUEST['id'];
        $nom = $_REQUEST['nom'];
        $rue = $_REQUEST['rue']; 
        $type = $_REQUEST['type'];
        $arrondissement = $_REQUEST['arrondissement'];
        $etage = $_REQUEST['etage'];
        $ascenseur = $_REQUEST['ascenseur'];
        $prixCharges = $_REQUEST['prixcharges'];
        $prixLoc = $_REQUEST['prixlocation'];
        $preavis = $_REQUEST['preavis'];
        $dateLibre=date('d/m/y');

        if($nom && $rue && $type && $arrondissement && $etage && $ascenseur && $prixCharges && $prixLoc  && $preavis)
        {
            if($ascenseur == "oui")
            {
                $ascenseur = true;
            }
            else
            {
                $ascenseur = false;
            }

            if($preavis == "oui")
            {
                $preavis = true;
            }
            else
            {
                $preavis = false;
            }
            
            str_replace("/","",$id);
            $proprietaire=$this->getDoctrine()->getRepository(Proprietaire::class)->find($id);
            $dateLibre = new \DateTime("$dateLibre 00:00:00");
            $appartement = new Appartement($nom,$type,$prixLoc,$prixCharges,$rue,$arrondissement,$etage,$ascenseur,$preavis,$dateLibre,$proprietaire);
            $entityManager = $this -> getDoctrine() -> getManager();
            $entityManager -> persist($appartement);
            $entityManager -> flush();

                return $this->render('proprietaire/creationSuccess.html.twig', [
                    'appartement' => $appartement,
                ]);
        }
        else {
            return $this->render('proprietaire/nouvelAppartement.html.twig', [
                'appartement' => $appartement,
            ]);
        }
    }


    /**
     * @Route("/supprimerAppartementPro", name="supprimerAppartementPro")
     */
    public function supprimerAppartementPro()
    {
        $id = $_REQUEST['id'];
        $appart = $this -> getDoctrine() -> getRepository(Appartement::Class) -> findOneBy(array('id'=>"$id"));
        $entityManager = $this -> getDoctrine() -> getManager();
        $entityManager -> remove($appart);
        $entityManager -> flush();
        return $this->render('proprietaire/appartements.html.twig', [
        ]); 
    }

    /**
     * @Route("/modificationAppartement", name="modificationAppartement")
     */
    public function modificationAppartement()
    {
        $id = $_REQUEST['id'];
        $appartement = $this->getDoctrine()->getRepository(Appartement::class)-> findOneBy(array('id'=>$id));
        return $this->render('proprietaire/modificationAppartement.html.twig', [
            "appartement" => $appartement,
        ]);
    }

    /**
     * @Route("/valideModificationAppartement", name="valideModificationAppartement")
     */
    public function valideModificationAppartement()
    {
        $id=$_REQUEST['id'];
        $appartement = $this->getDoctrine()->getRepository(Appartement::class)-> findOneBy(array('id'=>$id));
        $nom = $_REQUEST['nom'];
        $rue = $_REQUEST['rue']; 
        $prixCharges = $_REQUEST['prixcharges'];
        $prixLoc = $_REQUEST['prixlocation'];
        if ($nom&&$rue&&$prixCharges&&$prixLoc){
           
            $nom = $this->getDoctrine()->getRepository(Appartement::class)->find($id)->setNom($nom);
            $rue = $this->getDoctrine()->getRepository(Appartement::class)->find($id)->setRue($rue);
            $prixCharges = $this->getDoctrine()->getRepository(Appartement::class)->find($id)->setPrixCharges($prixCharges);
            $prixLoc = $this->getDoctrine()->getRepository(Appartement::class)->find($id)->setPrixLoc($prixLoc);
            
            //faire les modifications dans la bdd
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->render('proprietaire/appartements.html.twig', [
            "appartement" => $this->getDoctrine()->getRepository(Appartement::class)-> findOneBy(array('id'=>$id)),
            ]);
         }
         print("Champs vides");
         return $this->render('proprietaire/appartements.html.twig');
    }


    /**
     * @Route("/voirMonProfilProprietaire", name="voirMonProfilProprietaire")
     */
    public function voirMonProfilProprietaire()
    {
        return $this->render('proprietaire/profil.html.twig', [
            'controller_name' => 'ProprietaireController',
        ]);
    }

    /**
     * @Route("/valideModificationProprietaire", name="valideModificationProprietaire")
     */
    public function valideModificationProprietaire()
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
            return $this->render('proprietaire/profil.html.twig');
        }
        print("Champs vides");
        return $this->render('proprietaire/profil.html.twig');
    }     
}

