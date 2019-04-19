<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Seo\AuditBundle\Entity\User;

class AccountController extends AbstractController
{
    /**
     * @Route("/accounts", name="account")
     */
    public function index()
    {
        return $this->render('account/index.html.twig', [
            'controller_name' => 'AccountController',
        ]);
    }

    /**
     * @Route("/account/create", name="createAccount")
     * @param           Request $request
     * @return          \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function createAccount(Request $request)
    {
        $form = $this->createForm(AccountForm::class, $FormData);
        $form->handleRequest($request);
        $FormData = new FormData();
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $User = new User();
            $User->setEmail($data->Email);
            $User->setUsername($data->Username);
            $User->setPassword($data->Password);
            $User->setName($data->Name);
            $User->setOfficePhone($data->OfficePhone);
            $User->setBillingStreet($data->BillingStreet);
            $User->setBillingCity($data->BillingCity);
            $User->setBillingPostalCode($data->BillingPostalCode);
            $User->setBillingCountry($data->BillingCountry);
            $User->setShippingStreet($data->ShippingStreet);
            $User->setShippingCity($data->ShippingCity);
            $User->setShippingState($data->ShippingState);
            $User->setShippingPostalCode($data->ShippingPostalCode);
            $User->setShippingCountry($data->ShippingCountry);
            $User->setDescription($data->Description);
            $User->setType($data->Type);
            $User->setAnnualRevenue($data->AnnualRevenue);
            $User->setSICCode($data->SICCode);
            $User->setIndustry($data->Industry);
            $User->setEmployees($data->Employees);
            $User->setTickerSymbol($data->TickerSymbol);
            $User->setOwnership($data->Ownership);
            $User->setRating($data->Rating);
            $User->persist($result);
            $User->flush();

            $this->addFlash('success', 'Account Sucessfully Created');

            return $this->render('Account/create.html.twig', array('form' => $form->createView()));
        }
    }



    /**
     * @Route("/account/search/{username}", name="searchAccount")
     * @param                 $username
     * @return                Response
     */
    public function searchAccount(Request $request)
    {
        $form = $this->createForm(AccountForm::class, $FormData);
        $form->handleRequest($request);
        $FormData = new FormData();
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $query = $em->createQuery('SELECT p FROM deicrm:ei_user p
    WHERE p.name LIKE :data')
   ->setParameter('data', $data->search);


            $res = $query->getResult();

            if (!$query) {
                $this->addFlash('success', 'No Account was found, Try Searching Again');
                return $this->render('Account/index.html.twig', array('form' => $form->createView()));
            } else {
                return $this->render('Account/search.html.twig', array('form' => $form->createView(), 'account' => $res));
            }
        }
    }




    /**
     * @Route("/account/edit/{username}", name="editAccount")
     * @param                 $username
     * @return                Response
     */
    public function editAccount(Request $request)
    {
        $form = $this->createForm(AccountForm::class, $FormData);
        $form->handleRequest($request);
        $FormData = new FormData();
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $result = $em->getRepository('deicrm')
      ->findOneBy(['dei_user' => $data->name]);
            if (!$result) {
                $this->addFlash('success', 'This Account is Invalid');
                return $this->render('Account/index.html.twig', array('form' => $form->createView()));
            } else {
                $User->setEmail($data->Email);
                $User->setUsername($data->Username);
                $User->setPassword($data->Password);
                $User->setName($data->Name);
                $User->setOfficePhone($data->OfficePhone);
                $User->setBillingStreet($data->BillingStreet);
                $User->setBillingCity($data->BillingCity);
                $User->setBillingPostalCode($data->BillingPostalCode);
                $User->setBillingCountry($data->BillingCountry);
                $User->setShippingStreet($data->ShippingStreet);
                $User->setShippingCity($data->ShippingCity);
                $User->setShippingState($data->ShippingState);
                $User->setShippingPostalCode($data->ShippingPostalCode);
                $User->setShippingCountry($data->ShippingCountry);
                $User->setDescription($data->Description);
                $User->setType($data->Type);
                $User->setAnnualRevenue($data->AnnualRevenue);
                $User->setSICCode($data->SICCode);
                $User->setIndustry($data->Industry);
                $User->setEmployees($data->Employees);
                $User->setTickerSymbol($data->TickerSymbol);
                $User->setOwnership($data->Ownership);
                $User->setRating($data->Rating);
                $User->persist($result);
                $User->flush();

                $this->addFlash('success', 'Account Sucessfully Created');

                return $this->render('Account/edit.html.twig', array('form' => $form->createView()));
            }
        }
    }

    /**
     * @Route("/account/all", name="getAllAccount")
     * @param                 $username
     * @return                Response
     */
    public function getAllAccount()
    {
        $em = $this->getDoctrine()->getManager();
        $result = $em->getRepository('deicrm:dei_user')
            ->findAll();
        if (!$result) {
            $this->addFlash('success', 'There are no created account');
            return $this->render('Account/all.html.twig', array('form' => $form->createView()));
        } else {
            return $this->render('Account/all.html.twig', array('form' => $form->createView(), 'account' => $result));
        }
    }




    /**
     * @Route("/account/{username}", name="getAccount")
     * @param                 $username
     * @return                Response
     */
    public function getAccount(Request $request)
    {
        $form = $this->createForm(AccountForm::class, $FormData);
        $form->handleRequest($request);
        $FormData = new FormData();
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $result = $em->getRepository('deicrm')
      ->findOneBy(['dei_user' => $data->name]);
            if (!$result) {
                $this->addFlash('success', 'This Account is Invalid');
                return $this->render('Account/index.html.twig', array('form' => $form->createView()));
            } else {
                return $this->render('Account/profile.html.twig', array('form' => $form->createView(), 'account' => $result));
            }
        }
    }

    /**
     * @Route("/account/del/{username}", name="delAccount")
     * @param                 $username
     * @return                Response
     */
    public function delAccount(Request $request)
    {
        $form = $this->createForm(AccountForm::class, $FormData);
        $form->handleRequest($request);
        $FormData = new FormData();
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $result = $em->getRepository('deicrm')
      ->findOneBy(['dei_user' => $data->name]);
            if (!$result) {
                $this->addFlash('success', 'This Account is Invalid');
                return $this->render('Account/index.html.twig', array('form' => $form->createView()));
            } else {
                $em->remove($result);
                $em->flush();
                $this->addFlash('success', 'Account sucessfully deleted');
                return $this->render('Account/index.html.twig', array('form' => $form->createView()));
            }
        }
    }
}
