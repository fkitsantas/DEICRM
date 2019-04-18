<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace CRM\ContactBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
// Import namespaces for Create contact properties
use CRM\ContactBundle\Entity\ContactMail;
use CRM\ContactBundle\Entity\Account;
use CRM\ContactBundle\Entity\ContactActivity;
use CRM\UserBundle\Entity\UserActivity;
use CRM\SaleBundle\Entity\Quote;
use CRM\ContactBundle\Form\AccountType;
use CRM\ContactBundle\Form\ContactMailType;
use CRM\ContactBundle\Form\ContactNoteType;
use CRM\UserBundle\Form\UserActivityType;
use CRM\ContactBundle\Form\ContactActivityType;

/**
 * Creates a new Contact entity.
 *
 * @Route("/create", name="CRMContactBundle_create_account")
 * @Method("post")
 * @Template("CRMContactBundle:Account:create.html.twig")
 */
class AccountController extends Controller {

    public function createAction() {
        $this->getTheme();
        $account = new Account();
        $form = $this->get('form.factory')->create(new AccountType(), $account);

        $request = $this->get('request');

        if ($request->getMethod() == 'POST') {
            $form->bind($request);
            if ($form->isValid()) {
                $em = $this->get('doctrine')->getManager();
                $account->setDateAdded(new \DateTime());
                $account->setCreationUser($this->getUser()->getUsername());
                $em->persist($account);
                $em->flush();

                $this->get('session')->getFlashBag()->set('notitce_create_success', 'You have successfully added '
                        . $account->getName() . ' to the database!');

                //insert activity to activity tables
                $this->getContactActivity("this_contact was created by creation_user", $account->getId());

                $this->getUserActivity("creation_user created new contact: " . $account->getName()
                        . " (" . $account->getPrimaryemail() . ")");

                //This page will redirect to View Profile.  
                return $this->redirect($this->generateUrl('CRMContactBundle_profile_account', array('id' => $account->getId())));
            }
        }

        return $this->render('CRMContactBundle:Account:create.html.twig', array(
                    'entity' => $account,
                    'form' => $form->createView()
        ));
    }

    public function manageAction() {
        $this->getTheme();
        $em = $this->getDoctrine()->getManager();

        $my_products = $em->createQueryBuilder()
                        ->select('count(c.id)')
                        ->from('CRMSaleBundle:Product', 'c')
                        ->where('c.creationUser = :id')
                        ->setParameter('id', $this->getUser()->getUsername())
                        ->getQuery()->getSingleScalarResult();

        //Populate recent contact for widget 
        $offset = 0;
        $limit = 5;
        $accounts_recent = $em->createQueryBuilder()
                ->select('b')
                ->from('CRMContactBundle:Account', 'b')
                ->where('b.creation_user = :id')
                ->setParameter('id', $this->getUser()->getUsername())
                ->addOrderBy('b.dateAdded', 'DESC')
                ->setFirstResult($offset)
                ->setMaxResults($limit)
                ->getQuery()
                ->getResult();

        //Populate list of groups in Manage contact page
        $categories = $em->createQueryBuilder()
                ->select('b')
                ->from('CRMContactBundle:Category', 'b')
                ->where('b.creationUser = :id')
                ->setParameter('id', $this->getUser()->getUsername())
                ->getQuery()
                ->getResult();

        //Get count per category
        $accounts = $em->createQueryBuilder()
                ->select('b')
                ->from('CRMContactBundle:Account', 'b')
                ->where('b.creation_user = :id')
                ->setParameter('id', $this->getUser()->getUsername())
                ->addOrderBy('b.name', 'ASC')
                ->getQuery()
                ->getResult();

        return $this->render('CRMContactBundle:Account:manage.html.twig', array(
                    'accounts' => $accounts, 'categories' => $categories,
                    'accounts_recent' => $accounts_recent, 'my_products' => $my_products,
        ));
    }

    public function profileAction($id) {
        $this->getTheme();
        $enquiry = new ContactMail();
        $form = $this->createForm(new ContactMailType(), $enquiry);

        $request = $this->getRequest();
        if ($request->getMethod() == 'POST') {
            $form->bindRequest($request);

            if ($form->isValid()) {
                return $this->redirect($this->generateUrl('CRMContactBundle_profile_account', array('id' => $id)));
            }
        }


        $em = $this->getDoctrine()->getManager();

        $profile = $em->getRepository('CRMContactBundle:Account')->find($id);
        $edit_form = $this->createForm(new ContactNoteType(), $profile);
        if (!$profile) {
            throw $this->createNotFoundException('Unable to find Account.');
        }
        $deleteForm = $this->createDeleteForm($id);

        $offset = 0;
        $limit = 10;
        $recent_activities = $em->createQueryBuilder()
                ->select('b')
                ->from('CRMContactBundle:ContactActivity', 'b')
                ->addOrderBy('b.dateAdded', 'DESC')
                ->where('b.contactAccountId = :id')
                ->andWhere('b.contactModule = :account')
                ->setParameter('id', $id)
                ->setParameter('account', 'Account')
                ->setFirstResult($offset)
                ->setMaxResults($limit)
                ->getQuery()
                ->getResult();

        $offset = 0;
        $limit = 10;
        $recent_cases = $em->createQueryBuilder()
                ->select('b')
                ->from('CRMSupportBundle:Ticket', 'b')
                ->addOrderBy('b.creationDate', 'DESC')
                ->where('b.customerEmail = :id')
                ->orWhere('b.customerEmail = :addemail')
                ->setParameter('id', $profile->getPrimaryemail())
                ->setParameter('addemail', $profile->getAddEmail())
                ->setFirstResult($offset)
                ->setMaxResults($limit)
                ->getQuery()
                ->getResult();

        $count_ticket = $em->createQueryBuilder()
                        ->select('count(tix.id)')
                        ->from('CRMSupportBundle:Ticket', 'tix')
                        ->where('tix.customerEmail = :id')
                        ->orWhere('tix.customerEmail = :addemail')
                        ->setParameter('id', $profile->getPrimaryemail())
                        ->setParameter('addemail', $profile->getAddEmail())
                        ->getQuery()->getSingleScalarResult();

        return $this->render('CRMContactBundle:Account:profile.html.twig', array('id' => $id,
                    'profile' => $profile,
                    'form' => $form->createView(),
                    'recent_cases' => $recent_cases,
                    'recent_activities' => $recent_activities,
                    'count_ticket' => $count_ticket,
                    'edit_form' => $edit_form->createView(),
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * This forms display the data and will call updateAction to continually update the provided $id
     *
     * @Route("account/{id}/edit", name="CRMContactBundle_edit_account")
     * @Template()
     */
    public function editAction($id) {
        $this->getTheme();
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CRMContactBundle:Account')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Order entity.');
        }

        $edit_form = $this->createForm(new AccountType(), $entity);

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'edit_form' => $edit_form->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Contact entity.
     *
     * @Route("/{id}/update", name="CRMContactBundle_edit_account")
     * @Method("post")
     * @Template("CRMContactBundle:Account:edit.html.twig")
     */
    public function updateAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CRMContactBundle:Account')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Contact entity.');
        }

        $edit_form = $this->createForm(new AccountType(), $entity);


        $request = $this->getRequest();

        $edit_form->bind($request);


        if ($edit_form->isValid()) {
            $em->persist($entity);
            $em->flush();


            //insert activity to activity tables
            $this->getContactActivity("this_contact was updated by creation_user", $entity->getId());

            $this->getUserActivity("creation_user created new contact: " . $entity->getName()
                    . " (" . $entity->getPrimaryemail() . ")");

            return $this->redirect($this->generateUrl('CRMContactBundle_edit_account', array('id' => $id)));
        }

        return array(
            'entity' => $entity,
            'edit_form' => $edit_form->createView(),
        );
    }

    /**
     * Deletes a Account entity.
     *
     * @Route("/{id}/delete", name="CRMContactBundle_delete_account")
     * @Method("post")
     */
    public function deleteAction($id) {
        $delete_form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $delete_form->bind($request);

        if ($delete_form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('CRMContactBundle:Account')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Account.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('CRMContactBundle_manage_account'));
    }

    private function createDeleteForm($id) {
        return $this->createFormBuilder(array('id' => $id))
                        ->add('id', 'hidden')
                        ->getForm();
    }

    public function searchAction() {
        $this->getTheme();
        $em = $this->getDoctrine()->getManager();
        //populate contact for search
        $accounts = $em->createQueryBuilder()
                ->select('b')
                ->from('CRMContactBundle:Account', 'b')
                ->addOrderBy('b.dateAdded', 'DESC')
                ->getQuery()
                ->getResult();


        return $this->render('CRMContactBundle:Account:search.html.twig', array(
                    'accounts' => $accounts,
        ));
    }

    public function mailAction($id) {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('CRMContactBundle:Account')->find($id);

        $message = \Swift_Message::newInstance()

                // Give the message a subject
                ->setSubject('CRM:CandySoft Quick Mail')

                // Set the From address with an associative array
                ->setFrom($this->getUser()->getUsername())

                // Set the To addresses with an associative array
                ->setTo($entity->getPrimaryemail())

                // Give it a body
                ->setBody('Here is the message itself');

        $this->get('mailer')->send($message);
        return $this->redirect($this->generateUrl('CRMContactBundle_profile_account', array('id' => $id)));
    }

    public function noteAction($id) {
          $this->getTheme();
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('CRMContactBundle:Account')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Account entity.');
        }

        $edit_form = $this->createForm(new ContactNoteType(), $entity);
        $request = $this->getRequest();
        $edit_form->bind($request);

        //insert activity to activity tables
        $this->getContactActivity("this_contact was updated by creation_user", $entity->getId());

        $this->getUserActivity("creation_user update note for: " . $entity->getName()
                . " (" . $entity->getPrimaryemail() . ")");

        if ($edit_form->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('CRMContactBundle_profile_account', array('id' => $id)));
        }

        return $this->redirect($this->generateUrl('CRMContactBundle_profile_account', array('id' => $id)));
    }

    public function getContactActivity($activiydesc, $account_id) {
        $contact_activity = new ContactActivity();

        $form = $this->get('form.factory')->create(new ContactActivityType(), $contact_activity);

        $request = $this->get('request');

        if ($request->getMethod() == 'POST') {
            $form->bind($request);

            $contact_activity->setActivityDesc($activiydesc);

            $contact_activity->setDateAdded(new \DateTime());

            $contact_activity->setActivityUser($this->getUser()->getUsername());
            $contact_activity->setContactModule("Account");
            $contact_activity->setContactAccountId($account_id);
            $em = $this->get('doctrine')->getManager();
            $em->persist($contact_activity);
            $em->flush();
        }
    }

    public function getUserActivity($activiydesc) {
        $user_activity = new UserActivity();

        $form1 = $this->get('form.factory')->create(new UserActivityType(), $user_activity);

        $request = $this->get('request');

        if ($request->getMethod() == 'POST') {
            $form1->bind($request);

            $user_activity->setActivityDesc($activiydesc);
            $user_activity->setDateAdded(new \DateTime());
            $user_activity->setModule('Account');
            $user_activity->setActivityUser($this->getUser()->getUsername());
            $em = $this->get('doctrine')->getManager();
            $em->persist($user_activity);
            $em->flush();
        }
    }

    public function deleteUserActivity($username) {

        $em = $this->getDoctrine()->getEntityManager();
        $repo = $em->getRepository('CRMUserBundle:UserActivity');

        $entity = $repo->findOneBy(array('activityUser' => $username));
        $em->remove($entity);
        $em->flush();
    }

    public function createquoteAction($id) {
        
        $repository = $this->getDoctrine()
                ->getRepository('CRMUserBundle:GlobalParameter');
        $quote_id_prepend = $repository->createQueryBuilder('p')
                ->where('p.parameterCode = :a') 
                ->andWhere('p.creationUser = :u')
                ->setParameter('a', 'QUOTE_ID') 
                ->setParameter('u', $this->getUser()->getUsername())
                ->getQuery()
                ->getOneOrNullResult();

        if (!$quote_id_prepend) {
            $quote_prepend = "0";
        } else {
            $quote_prepend = $quote_id_prepend->getParameterValue();
        }

        $em = $this->getDoctrine()->getManager();
        //get account profile id and move data to Quote table
        $account = $em->getRepository('CRMContactBundle:Account')->find($id);

        $datetime = new \DateTime("now");
        $d = $datetime->format('ymdh');

        $quote = new Quote();

        try {
            $quote->setQuoteId($quote_prepend . $d);
            $quote->setQuoteName($account->getName());
            $quote->setQuoteSendTo($account->getPrimaryname());
            $quote->setCreatedDate(new \DateTime());
            $quote->setExpirationDate(date_modify($datetime, '+1 month'));
            $quote->setCreationUser($this->getUser()->getUsername());
            $quote->setAccountManager($account->getManager());
            $quote->setAccountName($account->getPrimaryname());
            $quote->setContactPerson($account->getPrimaryname());
            $quote->setCustomerStreet($account->getAddstreet());
            $quote->setCustomerCity($account->getAddcity());
            $quote->setCustomerState($account->getAddstate());
            $quote->setCustomerCountry($account->getAddcountry());
            $quote->setContactPhone($account->getAddPhone1());
            $quote->setCustomerFax($account->getAddFax());
            $quote->setCustomerMobile($account->getAddMobile());
            $quote->setContactEmail($account->getPrimaryemail());
            $quote->setAmountCurrency($this->getCurrency());
            $quote->setTotalDiscount('0');
            $quote->setTotalSurcharge('0');
            $quote->setTotalVat('0');
            $quote->setSubtotal('0');
            $quote->setAmountDue('0');
            $quote->setQuoteStatus('Draft');
            $em->persist($quote);
            $em->flush();

            $update_quote = $em->getRepository('CRMSaleBundle:Quote')->find($quote->getId());
            $update_quote->setQuoteId($quote->getQuoteId() . $quote->getId());
            $em->persist($update_quote);
            $em->flush();

            $this->getUserActivity("creation_user created new deal: " . $update_quote->getQuoteId());
            $this->get('session')->getFlashBag()->add('notice_success_create_fr_account', 'success');



            return $this->redirect($this->generateUrl('CRMSaleBundle_quote_edit', array(
                                'id' => $quote->getId(), 'quote_id' => $update_quote->getQuoteId(),)));
        } catch (\Exception $e) {
            $this->get('session')->getFlashBag()->add('notice_error_create_fr_account', 'error');

            return $this->redirect($this->generateUrl('CRMContactBundle_manage_account'));
        }
    }

    public function getCurrency() {
    	$repository = $this->getDoctrine()
    	->getRepository('CRMUserBundle:GlobalParameter');
    
    	$currency = $repository->createQueryBuilder('p')
    	->where('p.parameterCode = :a')
    	->andWhere('p.creationUser = :u')
    	->setParameter('a', 'CURRENCY')
    	->setParameter('u', $this->getUser()->getUsername())
    	->getQuery()
    	->getOneOrNullResult();
    
    	if (!$currency) {
    		$curr = "USD";
    	} else {
    		$curr = $currency->getParameterValue();
    	}
    
    	return $curr;
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
