<?php

namespace CRM\UserBundle\Controller;

use \FOS\UserBundle\Controller\SecurityController as BaseSecurityController;
use Symfony\Component\Security\Core\SecurityContext;

class SecurityController extends BaseSecurityController {

    public function loginAction() {
        $request = $this->container->get('request');
        /* @var $request \Symfony\Component\HttpFoundation\Request */
        $session = $request->getSession();
        /* @var $session \Symfony\Component\HttpFoundation\Session\Session */

        // get the error if any (works with forward and redirect -- see below)
        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        } elseif (null !== $session && $session->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
            $session->remove(SecurityContext::AUTHENTICATION_ERROR);
        } else {
            $error = '';
        }

        if ($error) {
            // TODO: this is a potential security risk (see http://trac.symfony-project.org/ticket/9523)
            $error = $error->getMessage();
        }
        // last username entered by the user
        $lastUsername = (null === $session) ? '' : $session->get(SecurityContext::LAST_USERNAME);

        $csrfToken = $this->container->get('form.csrf_provider')->generateCsrfToken('authenticate');

        return $this->renderLogin(array(
                    'last_username' => $lastUsername,
                    'error' => $error,
                    'csrf_token' => $csrfToken,
        ));
    }

    /**
     * @Route("/login_check", name="fos_user_security_check")
     */
    public function checkAction() {
        // The security layer will intercept this request
    }

    public function onLogoutSuccess(Request $request) {

// redirect the user to where they were before the login process begun.
      
    }

    /**
     * renders the wellcome layout
     * @Route("/welcome", name="CRMUserBundle_welcome")
     * @Template()
     */
    public function welcomeAction() {
        return $this->render('CrmUserBundle:User:index.html.twig');
    }

}
