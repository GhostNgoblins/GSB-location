<?php

namespace App\Controller;
use App\Entity\Personne;
use App\Entity\Arrondissement;
use App\Entity\Appartement;
use App\Entity\Proprietaire;
use App\Entity\Demandes;
use App\Entity\Locataire;
use App\Entity\Client;
use App\Entity\Visite;
use App\Entity\Admin;
use App\Entity\Banque;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ClientController extends AbstractController
{

    /**
     * @Route("/voirMonProfilClient", name="voirMonProfilClient")
     */
    public function voirMonProfilClient()
    {
        return $this->render('client/profil.html.twig', [
            'controller_name' => 'ClientController',
        ]);
    }

    /**
     * @Route("/voirLesAppartementsCli", name="voirLesAppartementsCli")
     */
    public function voirLesAppartementsCli()
    {
        $typeStudio = 'STUDIO' ;
        $typeF1 = 'F1' ;
        $typeF2 = 'F2' ;
        $typeF3 = 'F3' ;
        return $this->render('client/listeAppartements.html.twig', [
            "studios" => $this -> getDoctrine() -> getRepository(Appartement::class) -> findBy(array('type' => "$typeStudio")),
            "f1s" => $this -> getDoctrine() -> getRepository(Appartement::class) -> findBy(array('type' =>"$typeF1")),
            "f2s" => $this -> getDoctrine() -> getRepository(Appartement::class) -> findBy(array('type' =>"$typeF2")),
            "f3s" => $this -> getDoctrine() -> getRepository(Appartement::class) -> findBy(array('type' =>"$typeF3")),
        ]);
    }

    /**
     * @Route("/valideModificationClient", name="valideModificationClient")
     */
    public function valideModificationClient()
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
            $emailClient = $this->getDoctrine()->getRepository(Personne::class)->findOneBy(array('login'=>"$login"))->setEmail($email);
            $nomClient = $this->getDoctrine()->getRepository(Personne::class)->findOneBy(array('login'=>"$login"))->setNomPe($nom);
            $prenomClient = $this->getDoctrine()->getRepository(Personne::class)->findOneBy(array('login'=>"$login"))->setPrenomPe($prenom);
            $adresseClient = $this->getDoctrine()->getRepository(Personne::class)->findOneBy(array('login'=>"$login"))->setAdressePe($adresse);
            $codePostalClient = $this->getDoctrine()->getRepository(Personne::class)->findOneBy(array('login'=>"$login"))->setCodePostal($codePostal);
            $villeClient = $this->getDoctrine()->getRepository(Personne::class)->findOneBy(array('login'=>"$login"))->setNomVille($ville);
            $telClient = $this->getDoctrine()->getRepository(Personne::class)->findOneBy(array('login'=>"$login"))->setTelephonePe($tel);
            //faire les modifications dans la bdd
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->render('client/profil.html.twig');
        }
        print("Champs vides");
        return $this->render('client/profil.html.twig');
    }

    /**
     * @Route("/faireUneDemande", name="faireUneDemande")
     */
    public function faireUneDemande()
    {
        return $this->render('client/faireUneDemande.html.twig', [
            'controller_name' => 'ClientController',
        ]);
    }

    /**
     * @Route("/voirMesDemandes", name="voirMesDemandes")
     */
    public function voirMesDemandes()
    {
        return $this->render('client/infoDemandes.html.twig', [
            'controller_name' => 'ClientController',
        ]);
    }

    /**
     * @Route("/supprimeDemande", name="supprimeDemande")
     */
    public function supprimeDemande()
    {
        $id = $_REQUEST['id'];
        $demande = $this -> getDoctrine() -> getRepository(Demandes::Class) -> findOneBy(array('id'=>"$id"));
        $entityManager = $this -> getDoctrine() -> getManager();
        $entityManager -> remove($demande);
        $entityManager -> flush();
        return $this->render('client/infoDemandes.html.twig', [
        ]); 
    }

  /**
     * @Route("/supprimeVisite", name="supprimeVisite")
     */
    public function supprimeVisite()
    {
        $id = $_REQUEST['id'];
        $visite = $this -> getDoctrine() -> getRepository(Visite::Class) -> findOneBy(array('id'=>"$id"));
        $entityManager = $this -> getDoctrine() -> getManager();
        $entityManager -> remove($visite);
        $entityManager -> flush();
        return $this->render('client/infoVisites.html.twig', [
        ]); 
    }


    /**
     * @Route("/voirMesVisites", name="voirMesVisites")
     */
    public function voirMesVisites()
    {
        return $this->render('client/infoVisites.html.twig', [
            'controller_name' => 'ClientController',
        ]);
    }



/**
     * @Route("/demandeModificationVisite", name="demandeModificationVisite")
     */
    public function demandeModificationVisite()
    {
        $id = $_REQUEST['id'];
        $visite = $this -> getDoctrine() -> getRepository(Visite::Class) -> findOneBy(array('id'=>"$id"));
        return $this->render('client/demandeModificationVisite.html.twig', [
            "visite"=>$visite
        ]);
    }



/**
     * @Route("/demandeModificationDemande", name="demandeModificationDemande")
     */
    public function demandeModificationDemande()
    {
        $id = $_REQUEST['id'];
        $demande = $this -> getDoctrine() -> getRepository(Demandes::Class) -> findOneBy(array('id'=>"$id"));
        
        return $this->render('client/demandeModificationDemande.html.twig', [
            "demande"=>$demande
        ]);
    }

    /**
     * @Route("/valideModificationDemande", name="valideModificationDemande")
     */
    public function valideModificationDemande()
    {
         
        $id = $_REQUEST['id'];
        $datearr = $_REQUEST['datearr'];
        $datedep = $_REQUEST['datedep'];
        // if ($datearr&&$datedep){
            $datearr = new \DateTime("$datearr 00:00:00");//objet type date
            $datedep = new \DateTime("$datedep 00:00:00");
            $dateArr = $this->getDoctrine()->getRepository(Demandes::class)->find($id)->setDateArrivee($datearr);
            $dateDep = $this->getDoctrine()->getRepository(Demandes::class)->find($id)->setDateDepart($datedep);
            //faire les modifications dans la bdd
            $em = $this->getDoctrine()->getManager();
            $em->flush();
     return $this->render('client/infoDemandes.html.twig', [
        ]);
    }

     /**
     * @Route("/valideModificationVisite", name="valideModificationVisite")
     */
    public function valideModificationVisite()
    {
         
        $id = $_REQUEST['id'];
        $date = $_REQUEST['date'];
        // if ($date){
            $date = new \DateTime("$date 00:00:00");//objet de type date
            $dateV = $this->getDoctrine()->getRepository(Visite::class)->find($id)->setDateVisite($date);
            //faire les modifications dans la bdd
            $em = $this->getDoctrine()->getManager();
            $em->flush();
     return $this->render('client/infoVisites.html.twig', [
        ]);
    }





/**
     * @Route("/ajoutVisite", name="ajoutVisite")
     */
    public function ajoutVisite()
    {//ajouter une visite par le client
        return $this->render('client/ajoutVisite.html.twig',[
            "apparts"=>$this->getDoctrine()->getRepository(Appartement::class)->findAll()
        ]);
    }




 /**
     * @Route("/validAjoutV", name="validAjoutV")
     */
    public function validAjoutV()
    {   //valider la création de la visite du client
        $id = $_REQUEST['id']; 
        $nom = $_REQUEST['nom'];
        $date = $_REQUEST['date']; 
        $appart=$this->getDoctrine()->getRepository(Appartement::class)->findOneBy(array('nom'=>"$nom"));
        $id=$this->getDoctrine()->getRepository(Client::class)->find($id);
        $date = new \DateTime("$date 00:00:00");
        if ($date&&$appart){
            //si tous les champs sont remplis
            $visit = new Visite ($id,$date,$appart);
            //on créé alors le profil
            $em = $this->getDoctrine()->getManager();
            $em->persist($visit);
            $em->flush();
            return $this->render('client/infoVisites.html.twig');
            }
        else { 
                print("Veuillez saisir tous les champs");
                return $this->render('client/ajoutVisite.html.twig');
            }
    }





    /**
     * @Route("/ajoutDCli", name="ajoutDCli")
     */
    public function ajoutDCli()
    {
        //ajoute une demande pour le client
        $nb=$_REQUEST['nb'];
        return $this->render('client/ajoutDCli.html.twig',[
            "nb"=>$nb
        ]);
    }

/**
     * @Route("/propA", name="propA")
     */
    public function propA()
    {//propose les arrondissements
        return $this->render('client/propA.html.twig');
    }


 /**
     * @Route("/propDCli", name="propDCli")
     */
    public function propDCli()
    {
        //recupere les données pour créer la demande et la proposition des appartements
        $id = $_REQUEST['id'];
        if($_REQUEST['nb']==1){
            $a1=$_REQUEST['a1'];$a2=0;$a3=0;$a4=0;
        }
        if($_REQUEST['nb']==2){
            $a1=$_REQUEST['a1'];$a2=$_REQUEST['a2'];$a3=0;$a4=0;
        }
        if($_REQUEST['nb']==3){
            $a1=$_REQUEST['a1'];$a2=$_REQUEST['a2'];$a3=$_REQUEST['a3'];$a4=0;
        }
        if($_REQUEST['nb']==4){
            $a1=$_REQUEST['a1'];$a2=$_REQUEST['a2'];$a3=$_REQUEST['a3'];$a4=$_REQUEST['a4'];
        } $type=$_REQUEST['type'];
        $prix=$_REQUEST['prix']; $datearr=$_REQUEST['datearr']; $datedep=$_REQUEST['datedep']; 
        $datearr = new \DateTime("$datearr 00:00:00"); 
        $datedep = new \DateTime("$datedep 00:00:00");//objet de type date
        $appart=$this->getDoctrine()->getRepository(Appartement::class)->findByField($type,$prix,$a1,$a2,$a3,$a4,$datearr);
        //proposition d'apparts
        //puis création de la demande
        $id=$this->getDoctrine()->getRepository(Client::class)->find($id);
        $dem = new Demandes ($type,$datearr,$datedep,$id);
        $em = $this->getDoctrine()->getManager();
        $em->persist($dem);
        $em->flush();
        $idD=$this-> getDoctrine()->getRepository(Demandes::class)->findMax()->getId(); 
        //ajoutes les arrondissements à la collection de la demande selon leur nombre
        if($_REQUEST['nb']==1){//si il n'y a qu'un arrondissement
            $a1=$this->getDoctrine()->getRepository(Arrondissement::class)->find($a1);
            $arron1 = $this->getDoctrine()->getRepository(Demandes::class)->find($idD)->addArrondissement($a1);
        }
        if($_REQUEST['nb']==2){//2 arrondissements
            $a1=$this->getDoctrine()->getRepository(Arrondissement::class)->find($a1);
            $a2=$this->getDoctrine()->getRepository(Arrondissement::class)->find($a2);
            $arron1 = $this->getDoctrine()->getRepository(Demandes::class)->find($idD)->addArrondissement($a1);
            $arron2 = $this->getDoctrine()->getRepository(Demandes::class)->find($idD)->addArrondissement($a2);
        }
        if($_REQUEST['nb']==3){//3 arrondissements
            $a1=$this->getDoctrine()->getRepository(Arrondissement::class)->find($a1);
            $a2=$this->getDoctrine()->getRepository(Arrondissement::class)->find($a2);
            $a3=$this->getDoctrine()->getRepository(Arrondissement::class)->find($a3);
            $arron1 = $this->getDoctrine()->getRepository(Demandes::class)->find($idD)->addArrondissement($a1);
            $arron2 = $this->getDoctrine()->getRepository(Demandes::class)->find($idD)->addArrondissement($a2);
            $arron3 = $this->getDoctrine()->getRepository(Demandes::class)->find($idD)->addArrondissement($a3);
        }
        if($_REQUEST['nb']==4){//4 arrondissements
            $a1=$this->getDoctrine()->getRepository(Arrondissement::class)->find($a1);
            $a2=$this->getDoctrine()->getRepository(Arrondissement::class)->find($a2);
            $a3=$this->getDoctrine()->getRepository(Arrondissement::class)->find($a3);
            $a4=$this->getDoctrine()->getRepository(Arrondissement::class)->find($a4);
            $arron1 = $this->getDoctrine()->getRepository(Demandes::class)->find($idD)->addArrondissement($a1);
            $arron2 = $this->getDoctrine()->getRepository(Demandes::class)->find($idD)->addArrondissement($a2);
            $arron3 = $this->getDoctrine()->getRepository(Demandes::class)->find($idD)->addArrondissement($a3);
            $arron4 = $this->getDoctrine()->getRepository(Demandes::class)->find($idD)->addArrondissement($a4);
        }
        //mettre a jour la bdd
        $em = $this->getDoctrine()->getManager();
        $em->persist($dem);
        $em->flush();
        //retour de la collection d'appartements compatibles avec la demande
        return $this->render('client/propositionDemande.html.twig',[
            "apparts"=>$appart
        ]);
    }





      
/**
     * @Route("/devenirLocataire", name="devenirLocataire")
     */
    public function devenirLocataire()
    {
        //changer de statut pour le client
        return $this->render('client/devenirLocataire.html.twig',[
            "apparts"=>$this->getDoctrine()->getRepository(Appartement::class)->findAll()
        ]);
    }


    /**
     * @Route("/validerLocataire", name="validerLocataire")
     */
    public function validerLocataire()
    {
        //valider le changement de statut de client à locataire
        $id = $_REQUEST['id'];
        $client = $this->getDoctrine()->getRepository(Client::class)->find($id);
        $nomA = $_REQUEST['nomA'];
        $nom = $client->getNomPe();
        $prenom = $client->getPrenomPe();
        $anniv = $client->getAnniv();
        $adresse = $client->getAdressePe();
        $cp = $client->getCodePostal();
        $ville = $client->getNomVille();
        $tel = $client->getTelephonePe();
        $email = $client->getEmail();
        $telB = $client->getTelBanque();
        $rib = $client->getNumCpteBanque();
        $login = $client->getUsername();
        $mdp = $client->getPassword();
        //recupe tous les champs du client pour les donner au locataire
        $idB=$this->getDoctrine()->getRepository(Banque::class)->find(1);
        $idA=$this->getDoctrine()->getRepository(Appartement::class)->findOneBy(array('nom'=>"$nomA"));
        $locs=$this->getDoctrine()->getRepository(Locataire::class)->findAll();
        // foreach ($locs as $loc){//si l'appartement est déjà occupé
        //     if($nomA==$loc->getAppartements()->getNom()){
        //         print("Appartement déjà occupé");//changement pas accepté
        //         return $this->render('client/devenirLocataire.html.twig',[
        //             "apparts"=>$this->getDoctrine()->getRepository(Appartement::class)->findAll()
        //             ]);
        //     }
        
        // }//le client devient locataire
        $user = new Locataire ($nom,$prenom,$adresse,$ville,$cp,$tel,$anniv,$login,$mdp,$rib,$email,$telB,$idB,$idA);
         $em = $this->getDoctrine()->getManager();
        $em->remove($client);//on supprime le client
        $em->persist($user);//on créé le locataire
        $em->flush();
        return $this->render('default/index.html.twig');
    }



}
