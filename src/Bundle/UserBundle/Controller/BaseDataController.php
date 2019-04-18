<?php

/*
 * This application belongs to Rhea Software (rheasoftware.com)
 * Illegal distribution is prohibited and punishable by law.  * 
 */

namespace CRM\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use CRM\SaleBundle\Entity\PayTerm;
use CRM\SaleBundle\Form\PayTermType;
use CRM\SaleBundle\Entity\ShippingMethod;
use CRM\SaleBundle\Form\ShippingMethodType;
use CRM\UserBundle\Entity\UserActivity;
use CRM\UserBundle\Form\UserActivityType;

class BaseDataController extends Controller {

    public function unitsAction() {
        $this->getTheme();
        $em = $this->getDoctrine()->getManager();

        $count = $em->createQueryBuilder()
                        ->select('count(a.id)')
                        ->from('CRMSaleBundle:PayTerm', 'a')
                        ->where('a.creationUser = :user')
                        ->setParameter('user', $this->getUser()->getUsername())
                        ->getQuery()->getSingleScalarResult();

        $payterms = $em->createQueryBuilder()
                ->select('b')
                ->from('CRMSaleBundle:PayTerm', 'b')
                ->where('b.creationUser = :user')
                ->setParameter('user', $this->getUser()->getUsername())
                // ->addOrderBy('b.quoteName', 'ASC')
                ->getQuery()
                ->getResult();

        //Populate recent contact for widget
        $offset = 0;
        $limit = 1;
        $contact_recent = $em->createQueryBuilder()
                ->select('b')
                ->from('CRMSaleBundle:PayTerm', 'b')
                ->where('b.creationUser = :user')
                ->setParameter('user', $this->getUser()->getUsername())
                ->addOrderBy('b.creationDate', 'DESC')
                ->setFirstResult($offset)
                ->setMaxResults($limit)
                ->getQuery()
                ->getResult();

        $payterm = new PayTerm();
        //$payterm = new PayTerm();
        $form = $this->get('form.factory')->create(new PayTermType(), $payterm);
        $request = $this->get('request');
        if ($request->getMethod() == 'POST') {
            $form->bind($request);
            if ($form->isValid()) {
                $payterm->setCreationdate(new \DateTime());
                $payterm->setCreationUser($this->getUser()->getUsername());
                $em->persist($payterm);
                $em->flush();

                $this->getUserActivity("creation_user created base data : " . $payterm->getName());
                return $this->redirect($this->generateUrl('CRMUserBundle_base_data_units'));
            }
        }

        return $this->render('CRMUserBundle:BaseData:units.html.twig', array(
                    'payterms' => $payterms,
                    'parameters_recent' => $contact_recent,
                    'count' => $count,
                    'form' => $form->createView()
        ));
    }

    public function unitsdeleteAction($id) {
        $this->getTheme();
        $em = $this->getDoctrine()->getEntityManager();
        $entity = $em->getRepository('CRMSaleBundle:PayTerm')->find($id);
        $this->getUserActivity("creation_user deleted : " . $entity->getName());
        $em->remove($entity);
        $em->flush();

        $this->get('session')->getFlashBag()->add('notice_payterm_cat_delete', 'success');

        return $this->redirect($this->generateUrl('CRMUserBundle_base_data_units'));
    }

    public function shippingAction() {
        $this->getTheme();
        $em = $this->getDoctrine()->getManager();

        $count = $em->createQueryBuilder()
                        ->select('count(a.id)')
                        ->from('CRMSaleBundle:ShippingMethod', 'a')
                        ->where('a.creationUser = :user')
                        ->setParameter('user', $this->getUser()->getUsername())
                        ->getQuery()->getSingleScalarResult();

        $shippings = $em->createQueryBuilder()
                ->select('b')
                ->from('CRMSaleBundle:ShippingMethod', 'b')
                ->where('b.creationUser = :user')
                ->setParameter('user', $this->getUser()->getUsername())
                // ->addOrderBy('b.quoteName', 'ASC')
                ->getQuery()
                ->getResult();

        //Populate recent contact for widget
        $offset = 0;
        $limit = 1;
        $shipping_recent = $em->createQueryBuilder()
                ->select('b')
                ->from('CRMSaleBundle:ShippingMethod', 'b')
                ->where('b.creationUser = :user')
                ->setParameter('user', $this->getUser()->getUsername())
                ->addOrderBy('b.creationDate', 'DESC')
                ->setFirstResult($offset)
                ->setMaxResults($limit)
                ->getQuery()
                ->getResult();

        $shipping = new ShippingMethod();
        //$payterm = new PayTerm();
        $form = $this->get('form.factory')->create(new ShippingMethodType($this->getUser()->getUsername()), $shipping);
        $request = $this->get('request');
        if ($request->getMethod() == 'POST') {
            $form->bind($request);
            if ($form->isValid()) {
                $shipping->setCreationdate(new \DateTime());
                $shipping->setCreationUser($this->getUser()->getUsername());
                $em->persist($shipping);
                $em->flush();

                $this->getUserActivity("creation_user created base data: " . $shipping->getName());
                return $this->redirect($this->generateUrl('CRMUserBundle_base_data_shippings'));
            }
        }

        return $this->render('CRMUserBundle:BaseData:shipping.html.twig', array(
                    'shippings' => $shippings,
                    'shipping_recent' => $shipping_recent,
                    'count' => $count,
                    'form' => $form->createView()
        ));
    }

    public function shipdeleteAction($id) {

        $em = $this->getDoctrine()->getEntityManager();
        $entity = $em->getRepository('CRMSaleBundle:ShippingMethod')->find($id);
        $this->getUserActivity("creation_user deleted : " . $entity->getName());
        $em->remove($entity);
        $em->flush();

        $this->get('session')->getFlashBag()->add('notice_shipping_cat_delete', 'success');

        return $this->redirect($this->generateUrl('CRMUserBundle_base_data_shippings'));
    }

    public function getUserActivity($activiydesc) {

        $activity = new UserActivity();
        $form1 = $this->get('form.factory')->create(new UserActivityType(), $activity);
        $request1 = $this->get('request');

        if ($request1->getMethod() == 'POST') {
            $form1->bind($request1);
            $activity->setActivityDesc($activiydesc);
            $activity->setDateAdded(new \DateTime());
            $activity->setActivityUser($this->getUser()->getUsername());
            $activity->setModule('BaseData');
            $em1 = $this->get('doctrine')->getManager();
            $em1->persist($activity);
            $em1->flush();
        }
    }

    public function deleteUserActivity($username) {

        $em = $this->getDoctrine()->getEntityManager();
        $repo = $em->getRepository('CRMUserBundle:UserActivity');

        $entity = $repo->findOneBy(array('activityUser' => $username));
        $em->remove($entity);
        $em->flush();
    }

    public function getTheme() {
        $request = $this->getRequest();
        if ($request->query->get('skin')) {
            $em = $this->getDoctrine()->getManager();
            $user = $em->getRepository('CRMUserBundle:User')->find($this->getUser()->getId());
            $user->setTheme($request->query->get('skin'));
            $em->flush();
        }
    }

}
