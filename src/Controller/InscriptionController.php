<?php

namespace App\Controller;
use App\Entity\Personne;
use App\Entity\Proprietaire;
use App\Entity\Locataire;
use App\Entity\Client;
use App\Entity\Admin;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class InscriptionController extends AbstractController
{
    /**
     * @Route("/demandeInscription", name="demandeInscription")
     */
    public function demandeInscription()
    {
        return $this->render('inscription/formulaireInscription.html.twig', [
            'controller_name' => 'InscriptionController',
        ]);
    }

     /**
     * @Route("/valideInscription", name="valideInscription")
     */
    public function valideInscription(UserPasswordEncoderInterface $encoder)
    {
        $email = $_REQUEST['email']; 
        $nom = $_REQUEST['nom'];
        $prenom = $_REQUEST['prenom'];
        $dateNaiss = $_REQUEST['dateNaiss'];
        $adresse = $_REQUEST['adresse'];
        $codePostal = $_REQUEST['codePostal'];
        $ville = $_REQUEST['ville'];
        $tel = $_REQUEST['numTel'];
        $numTelBanque = $_REQUEST['numTelBanque'];
        $numCptEnBanque = $_REQUEST['numCptEnBanque'];
        $login = $_REQUEST['login'];
        $motDePasse = $_REQUEST['motDePasse'];
        $type = $_REQUEST['type'];

        if($email && $nom && $prenom && $dateNaiss && $adresse && $codePostal && $ville && $tel && $numTelBanque && $numCptEnBanque && $login && $motDePasse && $type)
        {
            $utilisateur = $this -> getDoctrine() -> getRepository(Personne::Class) -> findBy(array('login'=>'$login'));
            if($utilisateur == NULL)
            {
                if($type == 'client')
                {
                    $dateNaiss = new \DateTime("$dateNaiss 00:00:00");
                    $user = new Client($nom,$prenom,$adresse,$ville,$codePostal,$tel,$dateNaiss,$login,$motDePasse,$numCptEnBanque,$email,$numTelBanque);
                    $entityManager = $this -> getDoctrine() -> getManager();
                    $entityManager -> persist($user);
                    $entityManager -> flush();
                    $encoded = $encoder->encodePassword($user, $motDePasse);
                    $user = $this -> getDoctrine() -> getRepository(Client::class) -> findOneBy(array('login'=>"$login")) -> setPassword($encoded);
                 }

                else if($type == 'propriétaire')
                {
                    $dateNaiss = new \DateTime("$dateNaiss 00:00:00");
                    $user = new Proprietaire($nom,$prenom,$adresse,$ville,$codePostal,$tel,$dateNaiss,$login,$motDePasse,$numCptEnBanque,$email,$numTelBanque);
                    $entityManager = $this -> getDoctrine() -> getManager();
                    $entityManager -> persist($user);
                    $entityManager -> flush();
                    $encoded = $encoder->encodePassword($user, $motDePasse);
                    $user = $this -> getDoctrine() -> getRepository(Proprietaire::class) -> findOneBy(array('login'=>"$login")) -> setPassword($encoded);
                }

                $entityManager = $this -> getDoctrine() -> getManager();
                $entityManager -> persist($user);
                $entityManager -> flush(); // met à jour la base de donnée
                return $this->render('inscription/inscriptionSuccess.html.twig', [
                    'controller_name' => 'connexionController',
                ]);
            }
            else
            {   
                echo "login existant";
                return $this->render('inscription/formulaireInscription.html.twig', [
                    'controller_name' => 'inscriptionController',
                ]);
            } 
        }
        else
        {
        echo "un champs est vide...";
        return $this->render('inscription/formulaireInscription.html.twig', [
            'controller_name' => 'inscriptionController',
        ]);
        }
    }
}
