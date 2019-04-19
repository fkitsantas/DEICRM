<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Seo\AuditBundle\Form\FormData;

class SecurityController extends AbstractController
{
    /**
     * @Route("/admin", name="login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {


        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/admin.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }


    /**
    * @Route("/logout", name="app_logout", methods={"GET"})
    */
    public function logout()
    {
        // controller can be blank: it will never be executed!
        throw new \Exception('Don\'t forget to activate logout in security.yaml');
    }
}
