<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Seo\AuditBundle\Entity\User;

class LeadController extends AbstractController
{
    /**
     * @Route("/leads", name="lead")
     */
    public function index()
    {
        return $this->render('lead/index.html.twig', [
            'controller_name' => 'leadController',
        ]);
    }

    /**
     * @Route("/lead/create", name="createlead")
     * @param           Request $request
     * @return          \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function createlead(Request $request)
    {
        $form = $this->createForm(leadForm::class, $FormData);
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

            $this->addFlash('success', 'lead Sucessfully Created');

            return $this->render('lead/create.html.twig', array('form' => $form->createView()));
        }
    }



    /**
     * @Route("/lead/search/{username}", name="searchlead")
     * @param                 $username
     * @return                Response
     */
    public function searchlead(Request $request)
    {
        $form = $this->createForm(leadForm::class, $FormData);
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
                $this->addFlash('success', 'No lead was found, Try Searching Again');
                return $this->render('lead/index.html.twig', array('form' => $form->createView()));
            } else {
                return $this->render('lead/search.html.twig', array('form' => $form->createView(), 'lead' => $res));
            }
        }
    }




    /**
     * @Route("/lead/edit/{username}", name="editlead")
     * @param                 $username
     * @return                Response
     */
    public function editlead(Request $request)
    {
        $form = $this->createForm(leadForm::class, $FormData);
        $form->handleRequest($request);
        $FormData = new FormData();
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $result = $em->getRepository('deicrm')
      ->findOneBy(['dei_user' => $data->name]);
            if (!$result) {
                $this->addFlash('success', 'This lead is Invalid');
                return $this->render('lead/index.html.twig', array('form' => $form->createView()));
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

                $this->addFlash('success', 'lead Sucessfully Created');

                return $this->render('lead/edit.html.twig', array('form' => $form->createView()));
            }
        }
    }

    /**
     * @Route("/lead/all", name="getAlllead")
     * @param                 $username
     * @return                Response
     */
    public function getAlllead()
    {
        $em = $this->getDoctrine()->getManager();
        $result = $em->getRepository('deicrm:dei_user')
            ->findAll();
        if (!$result) {
            $this->addFlash('success', 'There are no created lead');
            return $this->render('lead/all.html.twig', array('form' => $form->createView()));
        } else {
            return $this->render('lead/all.html.twig', array('form' => $form->createView(), 'lead' => $result));
        }
    }




    /**
     * @Route("/lead/{username}", name="getlead")
     * @param                 $username
     * @return                Response
     */
    public function getlead(Request $request)
    {
        $form = $this->createForm(leadForm::class, $FormData);
        $form->handleRequest($request);
        $FormData = new FormData();
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $result = $em->getRepository('deicrm')
      ->findOneBy(['dei_user' => $data->name]);
            if (!$result) {
                $this->addFlash('success', 'This lead is Invalid');
                return $this->render('lead/index.html.twig', array('form' => $form->createView()));
            } else {
                return $this->render('lead/profile.html.twig', array('form' => $form->createView(), 'lead' => $result));
            }
        }
    }

    /**
     * @Route("/lead/del/{username}", name="dellead")
     * @param                 $username
     * @return                Response
     */
    public function dellead(Request $request)
    {
        $form = $this->createForm(leadForm::class, $FormData);
        $form->handleRequest($request);
        $FormData = new FormData();
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $result = $em->getRepository('deicrm')
      ->findOneBy(['dei_user' => $data->name]);
            if (!$result) {
                $this->addFlash('success', 'This lead is Invalid');
                return $this->render('lead/index.html.twig', array('form' => $form->createView()));
            } else {
                $em->remove($result);
                $em->flush();
                $this->addFlash('success', 'lead sucessfully deleted');
                return $this->render('lead/index.html.twig', array('form' => $form->createView()));
            }
        }
    }
}
