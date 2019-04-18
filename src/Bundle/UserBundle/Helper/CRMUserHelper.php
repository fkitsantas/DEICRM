<?php

/*
 * This software belongs to Rhea Software S.R.O. 
 * Any other information are specified in the software contract agreement. 
 */

namespace CRM\UserBundle\Helper;

use Symfony\Component\DependencyInjection\ContainerInterface as Container;
use CRM\UserBundle\Entity\UserActivity;
use CRM\UserBundle\Form\UserActivityType;

class CRMUserHelper {

    private $container;

    public function __construct(Container $container) {
        $this->container = $container;
    }

    public function getUserActivity($activiydesc) {

//        $activity = new UserActivity();
//        $form1 = $this->get('form.factory')->create(new UserActivityType(), $activity);
//        $request1 = $this->get('request');
//
//        if ($request1->getMethod() == 'POST') {
//            $form1->bind($request1);
//            $activity->setActivityDesc($activiydesc);
//            $activity->setDateAdded(new \DateTime());
//            $activity->setActivityUser($this->getUser()->getUsername());
//            $em1 = $this->get('doctrine')->getManager();
//            $em1->persist($activity);
//            $em1->flush();
//        }
    }

}
