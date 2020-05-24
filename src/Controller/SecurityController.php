<?php 

namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


use App\Entity\Personne;
use App\Entity\Admin;
use App\Entity\Appartement;
use App\Entity\Client;
use App\Entity\Locataire;
use App\Entity\Proprietaire;
use App\Entity\Arrondissement;
use App\Entity\Banque;
use App\Entity\Demandes;
use App\Entity\Visite;


class SecurityController extends AbstractController
{
    /**
    * @Route("/login", name="app_login")
    */
    public function login(AuthenticationUtils $authenticationUtils)
    {
       // $error = $authenticationUtils-getLastAuthenticationError();
        //$lastUsername = $authenticationUtils-getLastUsername();
        return $this->render('security/login.html.twig',[
            //"last_username"=>$lastUsername,
            //"error"=>$error
        ]);
    }
    /**
    *  @Route("/logout", name="app_logout")
    */  
    public function logout()
    {
       
    }

    /**
     * @Route("/client", name="client")
     */
    public function client()
    {
        return $this->render('client/indexClient.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }

    /**
     * @Route("/proprietaire", name="proprietaire")
     */
    public function proprietaire()
    {
        return $this->render('proprietaire/indexProprietaire.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }

    /**
     * @Route("/locataire", name="locataire")
     */
    public function locataire()
    {
        return $this->render('locataire/indexLocataire.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }

    /**
     * @Route("/admin", name="admin")
     */
    public function admin()
    {
        return $this->render('administrateur/indexAdmin.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }

    /**
     * @Route("/supprimerPersonne", name="supprimerPersonne")
     */

    public function supprimerPersonne()
    {
        $login = $_REQUEST['login'];
        $user = $this -> getDoctrine() -> getRepository(Personne::Class) -> findOneBy(array('login'=>"$login"));
        $entityManager = $this -> getDoctrine() -> getManager();
        $entityManager -> remove($user);
        $entityManager -> flush();
        return $this->render('administrateur/suppressionSuccess.html.twig', [
            'controller_name' => 'DefaultController',
        ]); 
    }
}
