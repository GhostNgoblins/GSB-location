<?php

namespace App\Controller;
use App\Entity\Personne;
use App\Entity\Proprietaire;
use App\Entity\Locataire;
use App\Entity\Client;
use App\Entity\Admin;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class LocataireController extends AbstractController
{
    /**
     * @Route("/indexLocataire", name="indexLocataire")
     */
    public function indexLocataire()
    {
        return $this->render('locataire/indexLocataire.html.twig', [
            'controller_name' => 'LocataireController',
        ]);
    }

        /**
     * @Route("/voirMonProfilLocataire", name="voirMonProfilLocataire")
     */
    public function voirMonProfilLocataire()
    {
        return $this->render('locataire/profil.html.twig', [
            'controller_name' => 'LocataireController',
        ]);
    }

    /**
     * @Route("/valideModificationLocataire", name="valideModificationLocataire")
     */
    public function valideModificationLocataire()
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
            $emailLocataire = $this->getDoctrine()->getRepository(Personne::class)->findOneBy(array('login'=>"$login"))->setEmail($email);
            $nomLocataire = $this->getDoctrine()->getRepository(Personne::class)->findOneBy(array('login'=>"$login"))->setNomPe($nom);
            $prenomLocataire = $this->getDoctrine()->getRepository(Personne::class)->findOneBy(array('login'=>"$login"))->setPrenomPe($prenom);
            $adresseLocataire = $this->getDoctrine()->getRepository(Personne::class)->findOneBy(array('login'=>"$login"))->setAdressePe($adresse);
            $codePostalLocataire = $this->getDoctrine()->getRepository(Personne::class)->findOneBy(array('login'=>"$login"))->setCodePostal($codePostal);
            $villeLocataire = $this->getDoctrine()->getRepository(Personne::class)->findOneBy(array('login'=>"$login"))->setNomVille($ville);
            $telLocataire = $this->getDoctrine()->getRepository(Personne::class)->findOneBy(array('login'=>"$login"))->setTelephonePe($tel);
            //faire les modifications dans la bdd
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->render('locataire/profil.html.twig');
        }
        print("Champs vides");
        return $this->render('locataire/profil.html.twig');
    }

    /**
     * @Route("/voirMonAppartementLocataire", name="voirMonAppartementLocataire")
     */
    public function voirMonAppartementLocataire()
    {
        $appartement=$this->getDoctrine()->getRepository(Locataire::class)->findAll();
        return $this->render('locataire/appartement.html.twig', [
            'appartement' => $appartement,
        ]);
    }

    /**
     * @Route("/voirMaBanque", name="voirMaBanque")
     */
    public function voirMaBanque()
    {
        return $this->render('locataire/infoBanque.html.twig', [
            
        ]);
    }


    /**
     * @Route("/validation", name="validation")
     */
    public function validation()
    {
        //demande confirmation pour changer de statut de locataire a client
        return $this->render('locataire/devenirClient.html.twig');
    }



/**
     * @Route("/devenirClient", name="devenirClient")
     */
    public function devenirClient()
    {
        //changer le statut de locataire a client
        $id = $_REQUEST['id'];
        $loc = $this->getDoctrine()->getRepository(Locataire::class)->find($id);
        $nom = $loc->getNomPe();
        $prenom = $loc->getPrenomPe();
        $anniv = $loc->getAnniv();
        $adresse = $loc->getAdressePe();
        $cp = $loc->getCodePostal();
        $ville = $loc->getNomVille();
        $tel = $loc->getTelephonePe();
        $email = $loc->getEmail();
        $telB = $loc->getTelBanque();
        $rib = $loc->getNumCpteBanque();
        $login = $loc->getUsername();
        $mdp = $loc->getPassword();//recupere tous les champs de locataire
        $user = new Client ($nom,$prenom,$adresse,$ville,$cp,$tel,$anniv,$login,$mdp,$rib,$email,$telB);
        $em = $this->getDoctrine()->getManager();//crée le client
        $em->remove($loc);//supprime le locataire
        $em->persist($user);
        $em->flush();
        return $this->render('default/index.html.twig');
    }
}
