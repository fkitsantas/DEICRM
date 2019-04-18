<?php

/*
 * This application belongs to Rhea Software (rheasoftware.com)
 * Illegal distribution is prohibited and punishable by law.  * 
 */

namespace CRM\UserBundle\Controller;

use Symfony\Component\HttpFoundation\Session;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use CRM\UserBundle\Entity\UserActivity;
use CRM\UserBundle\Form\MyProfileType;
use CRM\UserBundle\Form\UserActivityType;
use Symfony\Component\HttpFoundation\Request;
use CRM\UserBundle\Entity\GlobalParameter;
use CRM\UserBundle\Form\GlobalParameterType;
use CRM\UserBundle\Form\GlobalParameterCurrType;
class WorkspaceController extends Controller {

    public function indexAction() {
        $this->getTheme();
        $em = $this->getDoctrine()->getManager();

        $my_contacts = $em->createQueryBuilder()
                        ->select('count(c.id)')
                        ->from('CRMContactBundle:Contact', 'c')
                        ->where('c.creation_user = :id')
                        ->setParameter('id', $this->getUser()->getUsername())
                        ->getQuery()->getSingleScalarResult();

        $my_accounts = $em->createQueryBuilder()
                        ->select('count(c.id)')
                        ->from('CRMContactBundle:Account', 'c')
                        ->where('c.creation_user = :id')
                        ->setParameter('id', $this->getUser()->getUsername())
                        ->getQuery()->getSingleScalarResult();

        $my_deals = $em->createQueryBuilder()
                        ->select('count(c.id)')
                        ->from('CRMSaleBundle:Quote', 'c')
                        ->where('c.creationUser = :id')
                        ->setParameter('id', $this->getUser()->getUsername())
                        ->getQuery()->getSingleScalarResult();

        //Showing my latest Contacts Reports on Tab
        //Populate recent contact for widget
        $offset = 0;
        $limit = 20;
        $contacts_recent = $em->createQueryBuilder()
                ->select('b')
                ->from('CRMContactBundle:Contact', 'b')
                ->addOrderBy('b.dateAdded', 'DESC')
                ->where('b.creation_user = :id')
                ->setParameter('id', $this->getUser()->getUsername())
                ->setFirstResult($offset)
                ->setMaxResults($limit)
                ->getQuery()
                ->getResult();

        $accounts_recent = $em->createQueryBuilder()
                ->select('b')
                ->from('CRMContactBundle:Account', 'b')
                ->addOrderBy('b.dateAdded', 'DESC')
                ->where('b.creation_user = :id')
                ->setParameter('id', $this->getUser()->getUsername())
                ->setFirstResult($offset)
                ->setMaxResults($limit)
                ->getQuery()
                ->getResult();

        $quotes_recent = $em->createQueryBuilder()
                ->select('b')
                ->from('CRMSaleBundle:Quote', 'b')
                ->addOrderBy('b.createdDate', 'DESC')
                ->where('b.creationUser = :id')
                ->setParameter('id', $this->getUser()->getUsername())
                ->setFirstResult($offset)
                ->setMaxResults($limit)
                ->getQuery()
                ->getResult();

        return $this->render('CRMUserBundle:Workspace:index.html.twig', array(
                    'my_deals' => $my_deals,
                    'my_accounts' => $my_accounts,
                    'my_contacts' => $my_contacts,
                    'quotes_recent' => $quotes_recent,
                    'accounts_recent' => $accounts_recent,
                    'contacts_recent' => $contacts_recent,
                    'cases_recent' => $this->recent_tickets(),
                    'my_ticket' => $this->total_tickets(),));
    }

    public function myprofileAction($id) {
        $this->getTheme();
        $em = $this->getDoctrine()->getManager();

        $profile = $em->getRepository('CRMUserBundle:User')->find($id);


        if (!$profile) {
            throw $this->createNotFoundException('Unable to find record.');
        }
        $type = $this->getDoctrine()->getRepository('CRMUserBundle:UserRole');
        $user_types = $type->createQueryBuilder('a')
                ->select('u.name')
                ->join('a.role', 'u')
                ->where('a.user = :id')
                ->setParameter('id', $id)
                ->getQuery()
                ->getResult();

        //Populate recent contact for widget
        $offset = 0;
        $limit = 10;
        $recent_activities = $em->createQueryBuilder()
                ->select('b')
                ->from('CRMUserBundle:UserActivity', 'b')
                ->addOrderBy('b.dateAdded', 'DESC')
                ->where('b.activityUser = :id')
                ->setParameter('id', $profile->getUsername())
                ->setFirstResult($offset)
                ->setMaxResults($limit)
                ->getQuery()
                ->getResult();

        if ($profile->getCompanyName() == "") {
            $this->get('session')->getFlashBag()->add('missing_company', 'You have not filled up your Company name.');
        }

        return $this->render('CRMUserBundle:Workspace:myprofile.html.twig', array('id' => $id,
                    'profile' => $profile,
                    'user_types' => $user_types,
                    'cases_recent' => $this->recent_tickets(),
                    'my_ticket' => $this->total_tickets(),
                    'recent_activities' => $recent_activities));
    }

    public function activityAction($when) {
        $this->getTheme();
        $em = $this->getDoctrine()->getManager();

        $count = $em->createQueryBuilder()
                        ->select('count(c.id)')
                        ->from('CRMUserBundle:UserActivity', 'c')
                        ->where('c.activityUser = :id')
                        ->setParameter('id', $this->getUser()->getUsername())
                        ->getQuery()->getSingleScalarResult();

        $offset = 0;
        $limit = 20;
        $activities = $em->createQueryBuilder()
                ->select('b')
                ->from('CRMUserBundle:UserActivity', 'b')
                ->addOrderBy('b.dateAdded', 'DESC')
                ->where('b.activityUser = :id')
                ->setParameter('id', $this->getUser()->getUsername())
                ->setFirstResult($offset)
                ->setMaxResults($limit)
                ->getQuery()
                ->getResult();
        return $this->render('CRMUserBundle:Workspace:activity.html.twig', array('activities' => $activities, 'count' => $count));
    }

    public function statAction() {
        return $this->render('CRMUserBundle:Workspace:stats.html.twig');
    }

    /**
     * This forms display the data and will call updateAction to continually update the provided $id
     *
     * @Route("/{id}/edit", name="CRMUserBundle_edit_workspace")
     * @Template()
     */
    public function editAction($id) {
        $this->getTheme();
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CRMUserBundle:User')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find entity.');
        }

        $edit_form = $this->createForm(new MyProfileType(), $entity);

        return array(
            'entity' => $entity,
            'cases_recent' => $this->recent_tickets(),
            'my_ticket' => $this->total_tickets(),
            'edit_form' => $edit_form->createView()
        );
    }

    /**
     * Edits an existing User entity.
     *
     * @Route("/{id}/update", name="CRMUserBundle_edit_workspace")
     * @Method("post")
     * @Template("CRMContactBundle:Workspace:edit.html.twig")
     */
    public function updateAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CRMUserBundle:User')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }

        $originalPassword = $entity->getPassword();

        $edit_form = $this->createForm(new MyProfileType(), $entity);

        $request = $this->getRequest();

        $edit_form->bind($request);


        if ($edit_form->isValid()) {

            $plainPassword = $edit_form->get('password')->getData();
            if (!empty($plainPassword)) {
                //encode the password   
                $encoder = $this->container->get('security.encoder_factory')->getEncoder($entity); //get encoder for hashing pwd later
                $tempPassword = $encoder->encodePassword($entity->getPassword(), $entity->getSalt());
                $entity->setPassword($tempPassword);
            } else {
                $entity->setPassword($originalPassword);
            }

            $em->persist($entity);
            $em->flush();

            $this->getUserActivity("creation_user updated profile: " . $entity->getFullName(). "(" . $entity->getUsername() . ")");

            return $this->redirect($this->generateUrl('CRMUserBundle_edit_workspace', array('id' => $id)));
        }

        return array(
            'entity' => $entity,
            'cases_recent' => $this->recent_tickets(),
            'my_ticket' => $this->total_tickets(),
            'edit_form' => $edit_form->createView(),
        );
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
            $activity->setModule('Workspace');
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

    public function total_tickets() {
        $em = $this->getDoctrine()->getManager();

        $my_ticket = $em->createQueryBuilder()
                        ->select('count(tix.id)')
                        ->from('CRMSupportBundle:Ticket', 'tix')
                        ->where('tix.creationUser = :id')
                        ->setParameter('id', $this->getUser()->getUsername())
                        ->getQuery()->getSingleScalarResult();
        return $my_ticket;
    }

    public function recent_tickets() {
        $em = $this->getDoctrine()->getManager();
        $offset = 0;
        $limit = 20;
        $cases_recent = $em->createQueryBuilder()
                ->select('b')
                ->from('CRMSupportBundle:Ticket', 'b')
                ->addOrderBy('b.creationDate', 'DESC')
                ->where('b.creationUser = :id')
                ->setParameter('id', $this->getUser()->getUsername())
                ->setFirstResult($offset)
                ->setMaxResults($limit)
                ->getQuery()
                ->getResult();
        return $cases_recent;
    }

    public function searchAction(Request $request) {
        $this->getTheme();
        $em = $this->getDoctrine()->getManager();

        $request->query->get('q');

        $query = $em->createQuery(
                'SELECT a
                        FROM  CRMContactBundle:Contact a
                        INNER JOIN  CRMContactBundle:Account b
                        WHERE a.firstname LIKE \'' . $request->query->get('q') . '%\' 
                        and a.creation_user = \'' . $this->getUser()->getUsername() . '\'
                        ORDER BY a.dateAdded ASC'
        );

        $result = $query->getResult();
        return $this->render('CRMUserBundle:Workspace:search.html.twig', array('result' => $result));
    }

//    public function settingAction() {
//        $this->getTheme();
//        $em = $this->getDoctrine()->getManager();
//
//        $user = $em->getRepository('CRMUserBundle:User')->find($this->getUser()->getId());
//
//        if (!$user) {
//            throw $this->createNotFoundException('Unable to find entity.');
//        }
//        $quote_entity = $em->getRepository('CRMUserBundle:GlobalParameter')->findBy(
//                array('parameterCode' => 'QUOTE_ID', 'creationUser' => $this->getUser()->getUsername()));
//        $edit_form_quote = $this->createForm(new MyProfileType(), $quote_entity);
//
//
//        return $this->render('CRMUserBundle:Workspace:setting.html.twig', array(
//                    'edit_form_quote' => $edit_form_quote->createView(),
//        ));
//    }

    /**
     * This forms display the data and will call updateAction to continually update the provided $id
     *
     * @Route("/{id}/edit", name="CRMUserBundle_edit_setting_workspace")
     * @Template()
     */
    public function settingAction($id) {
        $this->getTheme();
        $em = $this->getDoctrine()->getManager();
        $repository = $this->getDoctrine()
                ->getRepository('CRMUserBundle:GlobalParameter');
        
         $currency_entity_count = $em->createQueryBuilder()
                        ->select('count(p.parameterId)')
                        ->from('CRMUserBundle:GlobalParameter', 'p')
                        ->where('p.parameterCode = :a')
                        ->andWhere('p.creationUser = :id')
                        ->setParameter('a', 'CURRENCY')
                        ->setParameter('id', $this->getUser()->getUsername())
                        ->getQuery()->getSingleScalarResult();
        
        if ($currency_entity_count == 0) {
                  $param = new GlobalParameter();
                  $param->setParameterCode('CURRENCY');
                  $param->setParameterValue('USD');
                  $param->setCreatedDate(new \DateTime());
                  $param->setCreationUser($this->getUser()->getUsername());

                  $em->persist($param);
                  $em->flush();
        }
        
        $currency_entity = $repository->createQueryBuilder('p')
                ->where('p.parameterCode = :a')
                ->andWhere('p.creationUser = :u')
                ->setParameter('a', 'CURRENCY')
                ->setParameter('u', $this->getUser()->getUsername())
                ->getQuery()
                ->getOneOrNullResult();

        $edit_form_currency = $this->createForm(new GlobalParameterCurrType(), $currency_entity);

        //INVOICE
        $invoice_entity_count = $em->createQueryBuilder()
                        ->select('count(p.parameterId)')
                        ->from('CRMUserBundle:GlobalParameter', 'p')
                        ->where('p.parameterCode = :a')
                        ->andWhere('p.creationUser = :id')
                        ->setParameter('a', 'INVOICE_NO')
                        ->setParameter('id', $this->getUser()->getUsername())
                        ->getQuery()->getSingleScalarResult();

        if ($invoice_entity_count == 0) {
            $param = new GlobalParameter();
            $param->setParameterCode('INVOICE_NO');
            $param->setParameterValue('');
            $param->setCreatedDate(new \DateTime());
            $param->setCreationUser($this->getUser()->getUsername());

            $em->persist($param);
            $em->flush();
        }

        $invoice_entity = $repository->createQueryBuilder('p')
                ->where('p.parameterCode = :a')
                ->andWhere('p.creationUser = :u')
                ->setParameter('a', 'INVOICE_NO')
                ->setParameter('u', $this->getUser()->getUsername())
                ->getQuery()
                ->getOneOrNullResult();

        $edit_form_invoice = $this->createForm(new GlobalParameterType(), $invoice_entity);

        ///QOUTE
        $quote_entity_count = $em->createQueryBuilder()
                        ->select('count(p.parameterId)')
                        ->from('CRMUserBundle:GlobalParameter', 'p')
                        ->where('p.parameterCode = :a')
                        ->andWhere('p.creationUser = :id')
                        ->setParameter('a', 'QUOTE_ID')
                        ->setParameter('id', $this->getUser()->getUsername())
                        ->getQuery()->getSingleScalarResult();

        if ($quote_entity_count == 0) {
            $param = new GlobalParameter();
            $param->setParameterCode('QUOTE_ID');
            $param->setParameterValue('');
            $param->setCreatedDate(new \DateTime());
            $param->setCreationUser($this->getUser()->getUsername());

            $em->persist($param);
            $em->flush();
        }

        $quote_entity = $repository->createQueryBuilder('p')
                ->where('p.parameterCode = :a')
                ->andWhere('p.creationUser = :u')
                ->setParameter('a', 'QUOTE_ID')
                ->setParameter('u', $this->getUser()->getUsername())
                ->getQuery()
                ->getOneOrNullResult();

        $edit_form_quote = $this->createForm(new GlobalParameterType(), $quote_entity);


        ///SALES ORDER
        $order_entity_count = $em->createQueryBuilder()
                        ->select('count(p.parameterId)')
                        ->from('CRMUserBundle:GlobalParameter', 'p')
                        ->where('p.parameterCode = :a')
                        ->andWhere('p.creationUser = :id')
                        ->setParameter('a', 'ORDER_REF')
                        ->setParameter('id', $this->getUser()->getUsername())
                        ->getQuery()->getSingleScalarResult();

        if ($order_entity_count == 0) {
            $param = new GlobalParameter();
            $param->setParameterCode('ORDER_REF');
            $param->setParameterValue('');
            $param->setCreatedDate(new \DateTime());
            $param->setCreationUser($this->getUser()->getUsername());

            $em->persist($param);
            $em->flush();
        }

        $order_entity = $repository->createQueryBuilder('p')
                ->where('p.parameterCode = :a')
                ->andWhere('p.creationUser = :u')
                ->setParameter('a', 'ORDER_REF')
                ->setParameter('u', $this->getUser()->getUsername())
                ->getQuery()
                ->getOneOrNullResult();

        $edit_form_order = $this->createForm(new GlobalParameterType(), $order_entity);


        ///CUST NO
        $cust_entity_count = $em->createQueryBuilder()
                        ->select('count(p.parameterId)')
                        ->from('CRMUserBundle:GlobalParameter', 'p')
                        ->where('p.parameterCode = :a')
                        ->andWhere('p.creationUser = :id')
                        ->setParameter('a', 'CUST_NO')
                        ->setParameter('id', $this->getUser()->getUsername())
                        ->getQuery()->getSingleScalarResult();

        if ($cust_entity_count == 0) {
            $param = new GlobalParameter();
            $param->setParameterCode('CUST_NO');
            $param->setParameterValue('');
            $param->setCreatedDate(new \DateTime());
            $param->setCreationUser($this->getUser()->getUsername());

            $em->persist($param);
            $em->flush();
        }

        $cust_entity = $repository->createQueryBuilder('p')
                ->where('p.parameterCode = :a')
                ->andWhere('p.creationUser = :u')
                ->setParameter('a', 'CUST_NO')
                ->setParameter('u', $this->getUser()->getUsername())
                ->getQuery()
                ->getOneOrNullResult();


        $edit_form_cust = $this->createForm(new GlobalParameterType(), $cust_entity);

        return array(
            'currency_entity' => $currency_entity,
            'quote_entity' => $quote_entity,
            'invoice_entity' => $invoice_entity,
            'order_entity' => $order_entity,
            'cust_entity' => $cust_entity,
            'edit_form_currency' => $edit_form_currency->createView(),
            'edit_form_quote' => $edit_form_quote->createView(),
            'edit_form_invoice' => $edit_form_invoice->createView(),
            'edit_form_order' => $edit_form_order->createView(),
            'edit_form_cust' => $edit_form_cust->createView(),
        );
    }

    /**
     * Edits an existing Contact entity.
     *
     * @Route("/{id}/update", name="CRMUserBundle_edit_setting_workspace")
     * @Method("post")
     * @Template("CRMUserBundle:Workspace:setting.html.twig")
     */
    public function updatesettingAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CRMUserBundle:GlobalParameter')->find($id);


        $edit_form = $this->createForm(new GlobalParameterType(), $entity);


        $request = $this->getRequest();

        $edit_form->bind($request);


        if ($edit_form->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('CRMUserBundle_edit_setting_workspace', array('id' => '0')));
        }

        return array(
            'entity' => $entity,
            'edit_form' => $edit_form->createView(),
        );
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
