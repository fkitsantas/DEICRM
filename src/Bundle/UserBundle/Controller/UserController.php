<?php

/*
 * This software belongs to Rhea Software S.R.O. 
 * Any other information are specified in the software contract agreement. 
 */

namespace CRM\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class UserController extends Controller {

    /**
   * checks the result of login attempt
   * @Route("/login", name="_login")
   * @Method({"GET","POST"})
   * @Template()
   */
  public function loginAction() {
    if ($this->get('request')->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
      $error = $this->get('request')->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
    } else {

      $error = $this->get('request')->getSession()->get(SecurityContext::AUTHENTICATION_ERROR);
    }
    return array(
      'last_email' => $this->get('request')->getSession()->get(SecurityContext::LAST_USERNAME),
      'error' => $error,
      'referer' => $this->getRequest()->getRequestUri(),  
    );
  }

    /**
     * @Route("/login_check", name="CRMUserBundle_login_check")
     */
    public function login_checkAction() {
        // The security layer will intercept this request
    }

    /**
     * @Route("/logout", name="_logout")
     */
    public function logoutAction() {
        // The security layer will intercept this request
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
