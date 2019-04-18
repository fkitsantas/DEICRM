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
use CRM\ContactBundle\Entity\Contact;
use CRM\ContactBundle\Entity\Category;
use CRM\ContactBundle\Entity\ContactMail;
use CRM\UserBundle\Entity\User;
use CRM\UserBundle\Entity\UserActivity;
use CRM\ContactBundle\Entity\ContactActivity;
use CRM\ContactBundle\Form\ContactNoteType;
use CRM\ContactBundle\Form\ContactType;
use CRM\ContactBundle\Form\CategoryType;
use CRM\ContactBundle\Form\ContactMailType;
use CRM\UserBundle\Form\UserActivityType;
use CRM\ContactBundle\Form\ContactActivityType;

class ProfileController extends Controller {

    public function indexAction() {
        $this->getTheme();
        $user = $this->getUser()->getUsername();
        $em = $this->getDoctrine()->getManager();

        //Populate list of groups in Manage contact page
//        $categories = $em->createQueryBuilder()
//                ->select('b')
//                ->from('CRMContactBundle:Category', 'b')
//                ->innerJoin('CRMContactBundle:Category','p')
//                ->getQuery()
//                ->getResult();

        $query = $em->createQuery(
                'SELECT COUNT( b.contact ) total_contact, a.name
                FROM CRMContactBundle:Category a
                INNER JOIN CRMContactBundle:ContactCatList b WITH a.id = b.category
                INNER JOIN CRMContactBundle:Contact c WITH b.contact = c.id
                WHERE c.creation_user = :user
                GROUP BY b.category');

        $query->setParameter('user', $user);
        $categories = $query->getResult();

        //Get count per category
        $contacts = $em->createQueryBuilder()
                ->select('b')
                ->from('CRMContactBundle:Contact', 'b')
                ->addOrderBy('b.firstname', 'ASC')
                ->where('b.creation_user = :id')
                ->setParameter('id', $user)
                ->getQuery()
                ->getResult();

        //Populate recent contact for widget 
        $offset = 0;
        $limit = 5;
        $contacts_recent = $em->createQueryBuilder()
                ->select('b')
                ->from('CRMContactBundle:Contact', 'b')
                ->addOrderBy('b.dateAdded', 'DESC')
                ->where('b.creation_user = :id')
                ->setParameter('id', $user)
                ->setFirstResult($offset)
                ->setMaxResults($limit)
                ->getQuery()
                ->getResult();

        return $this->render('CRMContactBundle:Profile:index.html.twig', array(
                    'contacts' => $contacts,
                    'contacts_recent' => $contacts_recent,
                    'categories' => $categories
        ));
    }

    /**
     * Creates a new Contact entity.
     *
     * @Route("/create", name="CRMContactBundle_create")
     * @Method("post")
     * @Template("CRMContactBundle:Profile:contact.html.twig")
     */
    public function createAction() {
        $this->getTheme();
        $em = $this->get('doctrine')->getManager();
        $contact = new Contact();
        $user = new User();

        $form = $this->get('form.factory')->create(new ContactType($this->getUser()->getUsername()), $contact);

        $request = $this->get('request');

        if ($request->getMethod() == 'POST') {
            $form->bind($request);
            if ($form->isValid()) {
                $em = $this->get('doctrine')->getManager();
                $contact->setDateAdded(new \DateTime());
                $contact->setCreationUser($this->getUser()->getUsername());
                $em->persist($contact);
                $em->flush();

                $this->get('session')->getFlashBag()->set('notice', 'You have successfully added '
                        . $contact->getFirstName() . ' ' . $contact->getLastName() . ' to the database!');

                //insert activity to activity tables
                $this->getContactActivity("this_contact was created by creation_user", $contact->getId());

                $this->getUserActivity("creation_user created new contact: " . $contact->getFirstName() . " " . $contact->getLastName()
                        . "(" . $contact->getEmail() . ")");

                //This page will redirect to View Profile.  
                return $this->redirect($this->generateUrl('CRMContactBundle_profile', array('id' => $contact->getId())));
            }
        }
        $accounts = $em->createQueryBuilder()
                ->select('b')
                ->from('CRMContactBundle:Account', 'b')
                ->addOrderBy('b.name', 'ASC')
                ->where('b.creation_user = :id')
                ->setParameter('id', $this->getUser()->getUsername())
                ->getQuery()
                ->getResult();

        return $this->render('CRMContactBundle:Profile:create.html.twig', array(
                    'entity' => $contact,
                    'accounts' => $accounts,
                    'form' => $form->createView()
        ));
    }

    /**
     * Finds and displays a Contact entity.
     *
     * @Route("/{id}/show", name="CRMContactBundle_profile")
     * @Template()
     */
    public function profileAction($id) {
        $this->getTheme();
        $enquiry = new ContactMail();
        $form = $this->createForm(new ContactMailType(), $enquiry);

        $request = $this->getRequest();
        if ($request->getMethod() == 'POST') {
            $form->bindRequest($request);

            if ($form->isValid()) {
                return $this->redirect($this->generateUrl('CRMContactBundle_profile', array('id' => $id)));
            }
        }

        $em = $this->getDoctrine()->getManager();

        $profile = $em->getRepository('CRMContactBundle:Contact')->find($id);
        $edit_form = $this->createForm(new ContactType($this->getUser()->getUsername()), $profile);

        if (!$profile) {
            throw $this->createNotFoundException('Unable to find Contact post.');
        }
        $type = $this->getDoctrine()->getRepository('CRMContactBundle:ContactCatList');
        $contact_types = $type->createQueryBuilder('a')
                ->select('u.name')
                ->join('a.category', 'u')
                ->where('a.contact = :id')
                ->setParameter('id', $id)
                ->getQuery()
                ->getResult();

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
                ->setParameter('account', 'Contact')
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
                ->setParameter('id', $profile->getEmail())
                ->setFirstResult($offset)
                ->setMaxResults($limit)
                ->getQuery()
                ->getResult();

        $count_ticket = $em->createQueryBuilder()
                        ->select('count(tix.id)')
                        ->from('CRMSupportBundle:Ticket', 'tix')
                        ->where('tix.customerEmail = :id')
                        ->setParameter('id', $profile->getEmail())
                        ->getQuery()->getSingleScalarResult();

        return $this->render('CRMContactBundle:Profile:profile.html.twig', array('id' => $id,
                    'profile' => $profile,
                    'count_ticket' => $count_ticket,
                    'contact_types' => $contact_types,
                    'form' => $form->createView(),
                    'recent_cases' => $recent_cases,
                    'recent_activities' => $recent_activities,
                    'edit_form' => $edit_form->createView(),
                    'delete_form' => $deleteForm->createView()));
    }

//    public function manageAction() {
//        $em = $this->getDoctrine()->getManager();
//
//        //Populate list of groups in Manage contact page
//        $categories = $em->createQueryBuilder()
//                ->select('b')
//                ->from('CRMContactBundle:Category', 'b')
//                ->getQuery()
//                ->getResult();
//
//        //Get count per category
//        $contacts = $em->createQueryBuilder()
//                ->select('b')
//                ->from('CRMContactBundle:Contact', 'b')
//                ->addOrderBy('b.firstname', 'ASC')
//                ->getQuery()
//                ->getResult();
//
//        //Populate recent contact for widget 
//        $offset = 0;
//        $limit = 5;
//        $contacts_recent = $em->createQueryBuilder()
//                ->select('b')
//                ->from('CRMContactBundle:Contact', 'b')
//                ->addOrderBy('b.dateAdded', 'DESC')
//                ->setFirstResult($offset)
//                ->setMaxResults($limit)
//                ->getQuery()
//                ->getResult();
//
//        return $this->render('CRMContactBundle:Profile:manage.html.twig', array(
//                    'contacts' => $contacts,
//                    'contacts_recent' => $contacts_recent,
//                    'categories' => $categories
//        ));
//    }

    public function searchAction() {
        $this->getTheme();
        $em = $this->getDoctrine()->getManager();
        //populate contact for search
        $contacts = $em->createQueryBuilder()
                ->select('b')
                ->from('CRMContactBundle:Contact', 'b')
                ->addOrderBy('b.dateAdded', 'DESC')
                ->getQuery()
                ->getResult();


        return $this->render('CRMContactBundle:Profile:search.html.twig', array(
                    'contacts' => $contacts,
        ));
    }

    /**
     * This forms display the data and will call updateAction to continually update the provided $id
     *
     * @Route("/{id}/edit", name="CRMContactBundle_edit")
     * @Template()
     */
    public function editAction($id) {
        $this->getTheme();
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CRMContactBundle:Contact')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Order entity.');
        }

        $edit_form = $this->createForm(new ContactType($this->getUser()->getUsername()), $entity);

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
     * @Route("/{id}/update", name="CRMContactBundle_edit")
     * @Method("post")
     * @Template("CRMContactBundle:Profile:edit.html.twig")
     */
    public function updateAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CRMContactBundle:Contact')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Contact entity.');
        }

        $edit_form = $this->createForm(new ContactType($this->getUser()->getUsername()), $entity);

        $previousCollections = $entity->getCatList();
        $previousCollections = $previousCollections->toArray();

        $request = $this->getRequest();

        $edit_form->bind($request);

        foreach ($previousCollections as $catlist) {
            $entity->removeCatList($catlist);
            $em->remove($catlist);
        }

        //insert activity to activity tables
        $this->getContactActivity("this_contact was updated by creation_user", $id);

        $this->getUserActivity("creation_user updated contact: " . $entity->getFirstName() . " " . $entity->getLastName()
                . "(" . $entity->getEmail() . ")");

        if ($edit_form->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('CRMContactBundle_edit', array('id' => $id)));
        }

        return array(
            'entity' => $entity,
            'edit_form' => $edit_form->createView(),
        );
    }

    /**
     * Deletes a Contact entity.
     *
     * @Route("/{id}/delete", name="CRMContactBundle_delete")
     * @Method("post")
     */
    public function deleteAction($id) {
        $delete_form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $delete_form->bind($request);

        if ($delete_form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('CRMContactBundle:Contact')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Order entity.');
            }

            $this->getUserActivity("creation_user deleted contact: " . $entity->getFirstName() . " " . $entity->getLastName()
                    . "(" . $entity->getEmail() . ")");

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('CRMContactBundle_homepage'));
    }

    private function createDeleteForm($id) {
        return $this->createFormBuilder(array('id' => $id))
                        ->add('id', 'hidden')
                        ->getForm();
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
            $contact_activity->setContactModule("Contact");
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
            $user_activity->setActivityUser($this->getUser()->getUsername());
            $em = $this->get('doctrine')->getManager();
            $user_activity->setModule('Contact');
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

    public function mailAction($id) {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('CRMContactBundle:Contact')->find($id);

        $message = \Swift_Message::newInstance()

                // Give the message a subject
                ->setSubject('CRM:CandySoft Quick Mail')

                // Set the From address with an associative array
                ->setFrom($this->getUser()->getUsername())

                // Set the To addresses with an associative array
                ->setTo($entity->getEmail())

                // Give it a body
                ->setBody('Here is the message itself');

        $this->get('mailer')->send($message);
        return $this->redirect($this->generateUrl('CRMContactBundle_profile', array('id' => $id)));
    }

    /**
     * Edits an existing Contact entity.
     *
     * @Route("/{id}/update", name="CRMContactBundle_profile")
     * @Method("post")
     * @Template("CRMContactBundle:Profile:profile.html.twig")
     */
    public function noteAction($id) {
        $this->getTheme();
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('CRMContactBundle:Contact')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Contact entity.');
        }

        $edit_form = $this->createForm(new ContactNoteType(), $entity);
        $request = $this->getRequest();
        $edit_form->bind($request);

        //insert activity to activity tables
        $this->getContactActivity("this_contact was updated by creation_user", $id);

        $this->getUserActivity("creation_user updated contact: " . $entity->getFirstName() . " " . $entity->getLastName()
                . "(" . $entity->getEmail() . ")");

        if ($edit_form->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('CRMContactBundle_profile', array('id' => $id)));
        }

        return $this->redirect($this->generateUrl('CRMContactBundle_profile', array('id' => $id)));
    }

    public function categoryAction() {
        $this->getTheme();
        $em = $this->getDoctrine()->getManager();

        $count = $em->createQueryBuilder()
                        ->select('count(a.id)')
                        ->from('CRMContactBundle:Category', 'a')
                        ->where('a.creationUser = :user')
                        ->setParameter('user', $this->getUser()->getUsername())
                        ->getQuery()->getSingleScalarResult();

        $categories = $em->createQueryBuilder()
                ->select('b')
                ->from('CRMContactBundle:Category', 'b')
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
                ->from('CRMContactBundle:Category', 'b')
                ->where('b.creationUser = :user')
                ->setParameter('user', $this->getUser()->getUsername())
                ->addOrderBy('b.creationDate', 'DESC')
                ->setFirstResult($offset)
                ->setMaxResults($limit)
                ->getQuery()
                ->getResult();

        $category = new Category();
        //$payterm = new PayTerm();
        $form = $this->get('form.factory')->create(new CategoryType(), $category);
        $request = $this->get('request');
        if ($request->getMethod() == 'POST') {
            $form->bind($request);
            if ($form->isValid()) {
                $category->setCreationdate(new \DateTime());
                $category->setCreationUser($this->getUser()->getUsername());
                $em->persist($category);
                $em->flush();
                return $this->redirect($this->generateUrl('CRMContactBundle_category'));
            }
        }

        return $this->render('CRMContactBundle:Profile:category.html.twig', array(
                    'categories' => $categories,
                    'parameters_recent' => $contact_recent,
                    'count' => $count,
                    'form' => $form->createView()
        ));
    }

    public function deletecatAction($id) {


        $em = $this->getDoctrine()->getEntityManager();
        $count = $em->createQueryBuilder()
                        ->select('count(c.id)')
                        ->from('CRMContactBundle:ContactCatList', 'c')
                        ->where('c.category = :cat')
                        ->setParameter('cat', $id)
                        ->getQuery()->getSingleScalarResult();

        if ($count >= 1) {
            $this->get('session')->getFlashBag()->add('notice_contact_exists', 'error');
        } else {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('CRMContactBundle:Category')->find($id);

            $em->remove($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('notice_contact_cat_delete', 'success');
        }

        return $this->redirect($this->generateUrl('CRMContactBundle_category'));
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
