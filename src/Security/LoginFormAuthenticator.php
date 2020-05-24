<?php

namespace App\Security;

use Doctrine\ORM\EntityManagerInterface;
use http\Exception\InvalidArgumentException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\Exception\InvalidCsrfTokenException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\Security\Guard\Authenticator\AbstractFormLoginAuthenticator;
use Symfony\Component\Security\Http\Util\TargetPathTrait;
use App\Entity\Personne;

class LoginFormAuthenticator extends AbstractFormLoginAuthenticator
{
    use TargetPathTrait;
    private $currentUser;
    private $entityManager;
    private $urlGenerator;
    private $csrfTokenManager;
    private $passwordEncoder;


    public function __construct(EntityManagerInterface $entityManager, UrlGeneratorInterface $urlGenerator, CsrfTokenManagerInterface $csrfTokenManager,
                                UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->entityManager = $entityManager;
        $this->urlGenerator = $urlGenerator;
        $this->csrfTokenManager = $csrfTokenManager;
        $this->passwordEncoder = $passwordEncoder;

    }

    public function supports(Request $request)
    {
        return 'app_login' === $request->attributes->get('_route')
            && $request->isMethod('POST');
    }

    public function getCredentials(Request $request)
    {
        $credentials = [
            'login' => $request->request->get('login'),
            'password' => $request->request->get('password'),
            'csrf_token' => $request->request->get('_csrf_token'),
        ];
        $request->getSession()->set(
            Security::LAST_USERNAME,
            $credentials['login']
        );

        return $credentials;
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        $token = new CsrfToken('authenticate', $credentials['csrf_token']);
        if (!$this->csrfTokenManager->isTokenValid($token)) {
            throw new InvalidArgumentException("Oups");
        }

        $user = $this->entityManager->getRepository(Personne::class)->findOneBy(['login' => $credentials['login']]);

        if (!$user) {
            // fail authentication with a custom error
            throw new CustomUserMessageAuthenticationException('Identifiant non trouvé');
        }
        $this->currentUser = $user;
        return $user;
    }

    public function checkCredentials($credentials, UserInterface $user)
    {
        // Check the user's password or other credentials and return true or false
        // If there are no credentials to check, you can just return true
        // if($res = $this->passwordEncoder->isPasswordValid($user,$credentials['password'] ))
        // {
        //     // if($user->getAccountStatus() == 0)
        //     // {
        //     //     throw new CustomUserMessageAuthenticationException('Votre compte est suspendu');
        //     // }
        //     // else{
        //     //     return $res;
        //     // }
        // }
        return $this->passwordEncoder->isPasswordValid($user,$credentials['password'] );

    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        return parent::onAuthenticationFailure($request, $exception); // TODO: Change the autogenerated stub
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        if ($targetPath = $this->getTargetPath($request->getSession(), $providerKey)) {
            return new RedirectResponse($targetPath);
        }

        // For example :
        if($this->currentUser->getType() === 'pro')
         {           
            return new RedirectResponse('/proprietaire');
         }
         if($this->currentUser->getType() === 'cli')
         {           
            return new RedirectResponse('/client');
         }
         if($this->currentUser->getType() === 'loc')
         {           
            return new RedirectResponse('/locataire');
         }
         if($this->currentUser->getType() === 'adm')
         {           
            return new RedirectResponse('/admin');
         }
        return new RedirectResponse($this->urlGenerator->generate('Accueil'));
        /*throw new \Exception('TODO: provide a valid redirect inside '.__FILE__);*/
    }

    protected function getLoginUrl()
    {
        return $this->urlGenerator->generate('app_login');
    }
}