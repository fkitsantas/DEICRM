<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Seo\AuditBundle\Entity\User;

class OpportunityController extends AbstractController
{
    /**
     * @Route("/Opportunitys", name="Opportunity")
     */
    public function index()
    {
        return $this->render('Opportunity/index.html.twig', [
            'controller_name' => 'OpportunityController',
        ]);
    }

    /**
     * @Route("/Opportunity/create", name="createOpportunity")
     * @param           Request $request
     * @return          \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function createOpportunity(Request $request)
    {
        $form = $this->createForm(OpportunityForm::class, $FormData);
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

            $this->addFlash('success', 'Opportunity Sucessfully Created');

            return $this->render('Opportunity/create.html.twig', array('form' => $form->createView()));
        }
    }



    /**
     * @Route("/Opportunity/search/{username}", name="searchOpportunity")
     * @param                 $username
     * @return                Response
     */
    public function searchOpportunity(Request $request)
    {
        $form = $this->createForm(OpportunityForm::class, $FormData);
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
                $this->addFlash('success', 'No Opportunity was found, Try Searching Again');
                return $this->render('Opportunity/index.html.twig', array('form' => $form->createView()));
            } else {
                return $this->render('Opportunity/search.html.twig', array('form' => $form->createView(), 'Opportunity' => $res));
            }
        }
    }




    /**
     * @Route("/Opportunity/edit/{username}", name="editOpportunity")
     * @param                 $username
     * @return                Response
     */
    public function editOpportunity(Request $request)
    {
        $form = $this->createForm(OpportunityForm::class, $FormData);
        $form->handleRequest($request);
        $FormData = new FormData();
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $result = $em->getRepository('deicrm')
      ->findOneBy(['dei_user' => $data->name]);
            if (!$result) {
                $this->addFlash('success', 'This Opportunity is Invalid');
                return $this->render('Opportunity/index.html.twig', array('form' => $form->createView()));
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

                $this->addFlash('success', 'Opportunity Sucessfully Created');

                return $this->render('Opportunity/edit.html.twig', array('form' => $form->createView()));
            }
        }
    }

    /**
     * @Route("/Opportunity/all", name="getAllOpportunity")
     * @param                 $username
     * @return                Response
     */
    public function getAllOpportunity()
    {
        $em = $this->getDoctrine()->getManager();
        $result = $em->getRepository('deicrm:dei_user')
            ->findAll();
        if (!$result) {
            $this->addFlash('success', 'There are no created Opportunity');
            return $this->render('Opportunity/all.html.twig', array('form' => $form->createView()));
        } else {
            return $this->render('Opportunity/all.html.twig', array('form' => $form->createView(), 'Opportunity' => $result));
        }
    }




    /**
     * @Route("/Opportunity/{username}", name="getOpportunity")
     * @param                 $username
     * @return                Response
     */
    public function getOpportunity(Request $request)
    {
        $form = $this->createForm(OpportunityForm::class, $FormData);
        $form->handleRequest($request);
        $FormData = new FormData();
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $result = $em->getRepository('deicrm')
      ->findOneBy(['dei_user' => $data->name]);
            if (!$result) {
                $this->addFlash('success', 'This Opportunity is Invalid');
                return $this->render('Opportunity/index.html.twig', array('form' => $form->createView()));
            } else {
                return $this->render('Opportunity/profile.html.twig', array('form' => $form->createView(), 'Opportunity' => $result));
            }
        }
    }

    /**
     * @Route("/Opportunity/del/{username}", name="delOpportunity")
     * @param                 $username
     * @return                Response
     */
    public function delOpportunity(Request $request)
    {
        $form = $this->createForm(OpportunityForm::class, $FormData);
        $form->handleRequest($request);
        $FormData = new FormData();
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $result = $em->getRepository('deicrm')
      ->findOneBy(['dei_user' => $data->name]);
            if (!$result) {
                $this->addFlash('success', 'This Opportunity is Invalid');
                return $this->render('Opportunity/index.html.twig', array('form' => $form->createView()));
            } else {
                $em->remove($result);
                $em->flush();
                $this->addFlash('success', 'Opportunity sucessfully deleted');
                return $this->render('Opportunity/index.html.twig', array('form' => $form->createView()));
            }
        }
    }
}
