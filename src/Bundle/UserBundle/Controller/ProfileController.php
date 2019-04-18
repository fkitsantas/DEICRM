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
// Import namespaces for Create user properties
use CRM\ContactBundle\Entity\Category;
use CRM\UserBundle\Entity\User;
use CRM\UserBundle\Entity\UserActivity;
use CRM\UserBundle\Form\UserType;
use CRM\UserBundle\Form\UserActivityType;
use CRM\SaleBundle\Entity\ShippingMethod;
use CRM\SaleBundle\Entity\PayTerm;

class ProfileController extends Controller {

    public function indexAction() {
        // return $this->render('CRMContactBundle:Profile:index.html.twig');
    }

    public function createAction() {
        $this->getTheme();
        $user = new User();
        $form = $this->get('form.factory')->create(new UserType(), $user);
        $request = $this->get('request');
        if ($request->getMethod() == 'POST') {
            $form->bind($request);
            if ($form->isValid()) {

                $em = $this->get('doctrine')->getManager();
                $user->setCreationDate(new \DateTime());
                $factory = $this->get('security.encoder_factory');
                $encoder = $factory->getEncoder($user);
                $password = $encoder->encodePassword($user->getPassword(), $user->getSalt());
                $user->setPassword($password);
                $user->setUsername($user->getEmail());
                $user->setCreationUser($this->getUser()->getUsername());
                $em->persist($user);
                $em->flush();

                $this->createInitialData($user->getEmail());

                $this->get('session')->getFlashBag()->set('notice', 'You have successfully added '
                        . $user->getFullName() . ' ' . $user->getLastName() . ' to the database!');

                $this->getUserActivity("creation_user updated profile: " . $entity->getFullName(). "(" . $entity->getUsername() . ")");

                //This page will redirect to View Profile.    
                return $this->redirect($this->generateUrl('CRMUserBundle_profile', array('id' => $user->getId())));
            }
        }

        return $this->render('CRMUserBundle:Profile:create.html.twig', array(
                    'entity' => $user,
                    'form' => $form->createView()
        ));
    }

    public function manageAction() {
        $this->getTheme();
        $em = $this->getDoctrine()->getManager();

        //Populate list of groups in Manage contact page
        $roles = $em->createQueryBuilder()
                ->select('b')
                ->from('CRMUserBundle:Role', 'b')
                ->getQuery()
                ->getResult();

        //Get count per category
        $users = $em->createQueryBuilder()
                ->select('b')
                ->from('CRMUserBundle:User', 'b')
                ->addOrderBy('b.fullname', 'ASC')
                ->getQuery()
                ->getResult();

        //Populate recent contact for widget 
        $offset = 0;
        $limit = 5;
        $users_recent = $em->createQueryBuilder()
                ->select('b')
                ->from('CRMUserBundle:User', 'b')
                ->addOrderBy('b.creation_date', 'DESC')
                ->setFirstResult($offset)
                ->setMaxResults($limit)
                ->getQuery()
                ->getResult();

        return $this->render('CRMUserBundle:Profile:manage.html.twig', array(
                    'users' => $users,
                    'users_recent' => $users_recent,
                    'roles' => $roles
        ));
    }

    public function searchAction() {
        $this->getTheme();
        $em = $this->getDoctrine()->getManager();
        //populate contact for search
        $users = $em->createQueryBuilder()
                ->select('b')
                ->from('CRMUserBundle:User', 'b')
                ->addOrderBy('b.creation_user', 'DESC')
                ->getQuery()
                ->getResult();


        return $this->render('CRMUserBundle:Profile:search.html.twig', array(
                    'users' => $users,
        ));
    }

    public function profileAction($id) {
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

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('CRMUserBundle:Profile:profile.html.twig', array('id' => $id,
                    'profile' => $profile,
                    'user_types' => $user_types,
                    'delete_form' => $deleteForm->createView(),
                    'recent_activities' => $recent_activities));
    }

    /**
     * This forms display the data and will call updateAction to continually update the provided $id
     *
     * @Route("/{id}/edit", name="CRMUserBundle_edit")
     * @Template()
     */
    public function editAction($id) {
        $this->getTheme();
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CRMUserBundle:User')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find entity.');
        }

        $edit_form = $this->createForm(new UserType(), $entity);

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'edit_form' => $edit_form->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing User entity.
     *
     * @Route("/{id}/update", name="CRMUserBundle_edit")
     * @Method("post")
     * @Template("CRMContactBundle:Profile:edit.html.twig")
     */
    public function updateAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CRMUserBundle:User')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }

        $originalPassword = $entity->getPassword();

        $edit_form = $this->createForm(new UserType(), $entity);

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

            return $this->redirect($this->generateUrl('CRMUserBundle_edit', array('id' => $id)));
        }

        return array(
            'entity' => $entity,
            'edit_form' => $edit_form->createView(),
        );
    }

    /**
     * Deletes a Contact entity.
     *
     * @Route("/{id}/delete", name="CRMUserBundle_delete")
     * @Method("post")
     */
    public function deleteAction($id) {
        $delete_form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $delete_form->bind($request);

        if ($delete_form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('CRMUserBundle:User')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Order entity.');
            }

            $this->deleteBasedRecords($entity->getUsername());


            $em->remove($entity);
            $em->flush();
        }

       $this->getUserActivity("creation_user updated profile: " . $entity->getFullName(). "(" . $entity->getUsername() . ")");
       
        return $this->redirect($this->generateUrl('CRMUserBundle_manage'));
    }

    private function createDeleteForm($id) {
        return $this->createFormBuilder(array('id' => $id))
                        ->add('id', 'hidden')
                        ->getForm()
        ;
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
            $activity->setModule('User');
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

    public function createInitialData($email) {
        $em = $this->get('doctrine')->getManager();

        ///When user information has been added, the initial data are consequently added. 
        //1. Contact Categories: (Lead & Opportunity):
        $contact_cat = new Category();
        $contact_cat->setName("Lead");
        $contact_cat->setCreationDate(new \DateTime());
        $contact_cat->setCreationUser($email);
        $em->persist($contact_cat);
        $em->flush();

        $contact_cat1 = new Category();
        $contact_cat1->setName("Opportunity");
        $contact_cat1->setCreationDate(new \DateTime());
        $contact_cat1->setCreationUser($email);
        $em->persist($contact_cat1);
        $em->flush();

        $shipping_method = new ShippingMethod();
        $shipping_method->setName('Free');
        $shipping_method->setAmount('0');
        $shipping_method->setCreationDate(new \DateTime());
        $shipping_method->setCreationUser($email);
        $em->persist($shipping_method);
        $em->flush();

        $payterm = new PayTerm();
        $payterm->setName('Piece');
        $payterm->setAbbrev('pc');
        $payterm->setCreationDate(new \DateTime());
        $payterm->setCreationUser($email);
        $em->persist($payterm);
        $em->flush();

        $payterm1 = new PayTerm();
        $payterm1->setName('Box');
        $payterm1->setAbbrev('box');
        $payterm1->setCreationDate(new \DateTime());
        $payterm1->setCreationUser($email);
        $em->persist($payterm1);
        $em->flush();

        $payterm2 = new PayTerm();
        $payterm2->setName('Pallet');
        $payterm2->setAbbrev('Pal');
        $payterm2->setCreationDate(new \DateTime());
        $payterm2->setCreationUser($email);
        $em->persist($payterm2);
        $em->flush();
    }

    //Delete all records when this user is deleted
    public function deleteBasedRecords($user) {
        $em = $this->get('doctrine')->getManager();
        $query = $em->createQuery("DELETE CRMUserBundle:UserActivity c WHERE c.activityUser = '" . $user . "'");
        $query->execute();

        $del_contact = $em->createQuery("DELETE CRMContactBundle:Contact c WHERE c.creation_user = '" . $user . "'");
        $del_contact->execute();

        $del_accounts = $em->createQuery("DELETE CRMContactBundle:Account c WHERE c.creation_user = '" . $user . "'");
        $del_accounts->execute();

        $del_catcontact = $em->createQuery("DELETE CRMContactBundle:Category c WHERE c.creationUser = '" . $user . "'");
        $del_catcontact->execute();

        $del_product = $em->createQuery("DELETE CRMSaleBundle:Product c WHERE c.creationUser = '" . $user . "'");
        $del_product->execute();

        $del_catproduct = $em->createQuery("DELETE CRMSaleBundle:ProductCategory c WHERE c.creationUser = '" . $user . "'");
        $del_catproduct->execute();

        $del_deals = $em->createQuery("DELETE CRMSaleBundle:Quote c WHERE c.creationUser = '" . $user . "'");
        $del_deals->execute();

        $del_dealsprod = $em->createQuery("DELETE CRMSaleBundle:QuoteProduct c WHERE c.creationUser = '" . $user . "'");
        $del_dealsprod->execute();

        $del_orders = $em->createQuery("DELETE CRMSaleBundle:SaleOrder c WHERE c.creationUser = '" . $user . "'");
        $del_orders->execute();

        $del_ordersprods = $em->createQuery("DELETE CRMSaleBundle:SaleOrderProduct c WHERE c.creationUser = '" . $user . "'");
        $del_ordersprods->execute();
        
        $del_payterm = $em->createQuery("DELETE CRMSaleBundle:PayTerm c WHERE c.creationUser = '" . $user . "'");
        $del_payterm->execute();

        $del_shipmeth = $em->createQuery("DELETE CRMSaleBundle:ShippingMethod c WHERE c.creationUser = '" . $user . "'");
        $del_shipmeth->execute();

        $del_tix = $em->createQuery("DELETE CRMSupportBundle:Ticket c WHERE c.creationUser = '" . $user . "'");
        $del_tix->execute();

        $del_tixcat = $em->createQuery("DELETE CRMSupportBundle:TicketCategory c WHERE c.creationUser = '" . $user . "'");
        $del_tixcat->execute();

        $del_tixrep = $em->createQuery("DELETE CRMSupportBundle:TicketReply c WHERE c.creationUser = '" . $user . "'");
        $del_tixrep->execute();
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
