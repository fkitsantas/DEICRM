<?php

/*
 * This application belongs to Rhea Software (rheasoftware.com)
 * Illegal distribution is prohibited and punishable by law.  * 
 */

namespace CRM\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class KnowledgeController extends Controller {

    public function faqAction() {

        return $this->render('CRMUserBundle:Knowledge:faq.html.twig');
    }



}
