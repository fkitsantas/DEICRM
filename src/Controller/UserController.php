<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Form\FormData;
use App\Form\User\UserForm;
use App\Form\User\UserEdit;
use App\Form\User\UserSearchForm;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController
{
    /**
     * @Route("/user", name="user")
     */
    public function index(Request $request)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $FormData = new FormData();
        $form = $this->createForm(userSearchForm::class, $FormData);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $user = $this->getDoctrine()
    ->getRepository(User::class)
    ->findByName($data->Search);

            if (!$user) {
                $this->addFlash('error', 'No user was found, Try Searching Again');
                return $this->render('user/index.html.twig', array('form' => $form->createView()));
            } else {
                return $this->render('user/index.html.twig', array('form' => $form->createView(), 'user' => $user, 'searchfor' => $data->Search));
            }
        }

        return $this->render('user/index.html.twig', [ 'form' => $form->createView()]);
    }

    /**
     * @Route("/user/create", name="createuser")
     * @param           Request $request
     * @return          \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function createuser(Request $request)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $FormData = new FormData();
        $form = $this->createForm(UserForm::class, $FormData);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $User = new User();
            $User->setEmailAddress($data->EmailAddress);
            $User->setFirstName($data->FirstName);
            $User->setLastName($data->LastName);
            $User->setIntial($data->Intial);
            $User->setPassword($data->Password);
            $User->setRoles($data->Roles);
            $User->setDateCreated(date('m/d/Y h:i:s a', time()));
            $User->setCreatedBy($this->getUser()->getId());
            $em->persist($User);
            $em->flush();


            $thisuser = $this->getDoctrine()
          ->getRepository(User::class)
          ->findOneByID($User->getID());

            $this->addFlash('success', 'User '.$thisuser->getName().' Sucessfully Created');
            return $this->redirectToRoute('getuser', ['id' => $thisuser->getID()]);
        }


        return $this->render('user/create.html.twig', array('form' => $form->createView()));
    }




    /**
     * @Route("/user/edit/{id}", name="edituser")
     * @param           Request $request
     * @return          \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function edituser(Request $request, $id)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $User = $this->getDoctrine()
      ->getRepository(User::class)
      ->findOneByID($id);



        if (!$User) {
            $this->addFlash('error', 'This user does not exist');

            return $this->render('user/index.html.twig');
        }


        $form = $this->createForm(UserEdit::class, $User);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $User->setEmailAddress($data->getEmailAddress());
            $User->setName($data->getName());
            $User->setWebsite($data->getWebsite());
            $User->setOfficePhone($data->getOfficePhone());
            $User->setFax($data->getFax());
            $User->setBillingAddressStreet($data->getBillingAddressStreet());
            $User->setBillingAddressCity($data->getBillingAddressCity());
            $User->setBillingAddressState($data->getBillingAddressState());
            $User->setBillingAddressPostalCode($data->getBillingAddressPostalCode());
            $User->setBillingAddressCountry($data->getBillingAddressCountry());
            $User->setShippingAddressStreet($data->getShippingAddressStreet());
            $User->setShippingAddressCity($data->getShippingAddressCity());
            $User->setShippingAddressState($data->getShippingAddressState());
            $User->setShippingAddressPostalCode($data->getShippingAddressPostalCode());
            $User->setType($data->getType());
            $User->setAnnualRevenue($data->getAnnualRevenue());
            $User->setSICCode($data->getSICCode());
            $User->setIndustry($data->getIndustry());
            $User->setEmployees($data->getEmployees());
            $User->setTickerSymbol($data->getTickerSymbol());
            $User->setOwnership($data->getOwnership());
            $User->setRating($data->getRating());
            $User->setDateModified(date('m/d/Y h:i:s a', time()));
            $em->persist($User);
            $em->flush();


            $thisuser = $this->getDoctrine()
          ->getRepository(User::class)
          ->findOneByID($User->getID());

            $this->addFlash('success', 'User '.$thisuser->getName().' Sucessfully Edited');
            return $this->redirectToRoute('getuser', ['id' => $thisuser->getID()]);
        }


        return $this->render('user/edit.html.twig', array('form' => $form->createView()));
    }




    /**
     * @Route("/user/all", name="getAlluser")
     * @return                Response
     */
    public function getAlluser()
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $em = $this->getDoctrine()->getManager();
        $result = $em->getRepository(User::class)
            ->findAll();
        if (!$result) {
            $this->addFlash('success', 'There are no created user');
            return $this->render('user/all.html.twig');
        } else {
            return $this->render('user/all.html.twig', ['user' => $result]);
        }
    }




    /**
     * @Route("/user/{id}", name="getuser")
     * @param                 $id
     * @return                Response
     */
    public function getuser($id)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getDoctrine()
        ->getRepository(User::class)
        ->findOneByID($id);


        if (!$user) {
            $this->addFlash('error', 'User not found');
            return $this->redirectToRoute('user');
        } else {
            $createdby = $this->getDoctrine()
          ->getRepository(User::class)
          ->findOneByID($user->getCreatedBy());



            return $this->render('user/view.html.twig', ['user' => $user, 'createdby' => $createdby]);
        }
    }

    /**
     * @Route("/user/del/{id}", name="deluser")
     * @param                 $id
     * @return                Response
     */
    public function deluser($id)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $User = $this->getDoctrine()
    ->getRepository(User::class)
    ->findOneByID($id);

        if (!$User) {
            $this->addFlash('error', 'Can not find user');
            return $this->redirectToRoute('getAlluser');
        } else {
            $em = $this->getDoctrine()->getManager();
            $em->remove($User);
            $em->flush();
            $this->addFlash('success', 'user sucessfully removed');
            return $this->redirectToRoute('getAlluser');
        }
    }
}
