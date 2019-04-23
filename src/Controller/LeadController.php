<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Lead;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Form\FormData;
use App\Form\Lead\LeadForm;
use App\Form\Lead\LeadEdit;
use App\Form\Lead\LeadSearchForm;

class LeadController extends AbstractController
{
    /**
     * @Route("/lead", name="lead")
     */
    public function index(Request $request)
    {
        $FormData = new FormData();
        $form = $this->createForm(leadSearchForm::class, $FormData);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $lead = $this->getDoctrine()
    ->getRepository(Lead::class)
    ->findByLastName($data->Search);

            if (!$lead) {
                $this->addFlash('error', 'No lead was found, Try Searching Again');
                return $this->render('lead/index.html.twig', array('form' => $form->createView()));
            } else {
                return $this->render('lead/index.html.twig', array('form' => $form->createView(), 'lead' => $lead, 'searchfor' => $data->Search));
            }
        }

        return $this->render('lead/index.html.twig', [ 'form' => $form->createView()]);
    }

    /**
     * @Route("/lead/create", name="createlead")
     * @param           Request $request
     * @return          \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function createlead(Request $request)
    {
        $FormData = new FormData();
        $form = $this->createForm(LeadForm::class, $FormData);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $Lead = new Lead();
            $Lead->setEmailAddress($data->EmailAddress);
            $Lead->setFirstName($data->FirstName);
            $Lead->setLastName($data->LastName);
            $Lead->setTitle($data->Title);
            $Lead->setDepartment($data->Department);
            $Lead->setOfficePhone($data->OfficePhone);
            $Lead->setMobile($data->Mobile);
            $Lead->setFax($data->Fax);
            $Lead->setPrimaryAddressStreet($data->PrimaryAddressStreet);
            $Lead->setPrimaryAddressCity($data->PrimaryAddressCity);
            $Lead->setPrimaryAddressState($data->PrimaryAddressState);
            $Lead->setPrimaryAddressPostalCode($data->PrimaryAddressPostalCode);
            $Lead->setPrimaryAddressCountry($data->PrimaryAddressCountry);
            $Lead->setAlternateAddressStreet($data->AlternateAddressStreet);
            $Lead->setAlternateAddressCity($data->AlternateAddressCity);
            $Lead->setAlternateAddressState($data->AlternateAddressState);
            $Lead->setAlternateAddressPostalCode($data->AlternateAddressPostalCode);
            $Lead->setAlternateAddressCountry($data->AlternateAddressCountry);
            $Lead->setEmailAddress($data->EmailAddress);
            $Lead->setDescription($data->Description);
            $Lead->setReferredBy($data->ReferredBy);
            $Lead->setLeadSource($data->LeadSource);
            $Lead->setStatus($data->Status);
            $Lead->setStatusDescription($data->StatusDescription);
            $Lead->setLeadDescription($data->LeadDescription);
            $Lead->setLeadSourceDescription($data->LeadSourceDescription);
            $Lead->setOpportunityAmount($data->OpportunityAmount);
            $Lead->setCampaign($data->Campaign);
            $Lead->setAssignedTo($data->AssignedTo);
            $Lead->setDateCreated(date('m/d/Y h:i:s a', time()));

            $Lead->setCreatedBy($this->getUser()->getId());
            $em->persist($Lead);
            $em->flush();


            $thislead = $this->getDoctrine()
          ->getRepository(Lead::class)
          ->findOneByID($Lead->getID());

            $this->addFlash('success', 'Lead '.$thislead->getLastName().' Sucessfully Created');
            return $this->redirectToRoute('getlead', ['id' => $thislead->getID()]);
        }


        return $this->render('lead/create.html.twig', array('form' => $form->createView()));
    }




    /**
     * @Route("/lead/edit/{id}", name="editlead")
     * @param           Request $request
     * @return          \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function editlead(Request $request, $id)
    {
        $Lead = $this->getDoctrine()
      ->getRepository(Lead::class)
      ->findOneByID($id);



        if (!$Lead) {
            $this->addFlash('error', 'This lead does not exist');

            return $this->render('lead/index.html.twig');
        }


        $form = $this->createForm(LeadEdit::class, $Lead);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $Lead->setEmailAddress($data->getEmailAddress());
            $Lead->setFirstName($data->getFirstName());
            $Lead->setLastName($data->getLastName());
            $Lead->setTitle($data->getTitle());
            $Lead->setDepartment($data->getDepartment());
            $Lead->setOfficePhone($data->getOfficePhone());
            $Lead->setMobile($data->getMobile());
            $Lead->setFax($data->getFax());
            $Lead->setPrimaryAddressStreet($data->getPrimaryAddressStreet());
            $Lead->setPrimaryAddressCity($data->getPrimaryAddressCity());
            $Lead->setPrimaryAddressState($data->getPrimaryAddressState());
            $Lead->setPrimaryAddressPostalCode($data->getPrimaryAddressPostalCode());
            $Lead->setPrimaryAddressCountry($data->getPrimaryAddressCountry());
            $Lead->setAlternateAddressStreet($data->getAlternateAddressStreet());
            $Lead->setAlternateAddressCity($data->getAlternateAddressCity());
            $Lead->setAlternateAddressState($data->getAlternateAddressState());
            $Lead->setAlternateAddressPostalCode($data->getAlternateAddressPostalCode());
            $Lead->setAlternateAddressCountry($data->getAlternateAddressCountry());
            $Lead->setEmailAddress($data->getEmailAddress());
            $Lead->setReferredBy($data->getReferredBy());
            $Lead->setLeadSource($data->getLeadSource());
            $Lead->setStatus($data->getStatus());
            $Lead->setStatusDescription($data->getStatusDescription());
            $Lead->setLeadSourceDescription($data->getLeadSourceDescription());
            $Lead->setLeadDescription($data->getLeadDescription());
            $Lead->setOpportunityAmount($data->getOpportunityAmount());
            $Lead->setDateCreated(date('m/d/Y h:i:s a', time()));
            $Lead->setDescription($data->getDescription());
            $Lead->setCampaign($data->getCampaign());
            $Lead->setAssignedTo($data->getAssignedTo());
            $Lead->setDateModified(date('m/d/Y h:i:s a', time()));
            $em->persist($Lead);
            $em->flush();


            $thislead = $this->getDoctrine()
          ->getRepository(Lead::class)
          ->findOneByID($Lead->getID());

            $this->addFlash('success', 'Lead '.$thislead->getLastName().' Sucessfully Edited');
            return $this->redirectToRoute('getlead', ['id' => $thislead->getID()]);
        }


        return $this->render('lead/edit.html.twig', array('form' => $form->createView()));
    }




    /**
     * @Route("/lead/all", name="getAlllead")
     * @return                Response
     */
    public function getAlllead()
    {
        $em = $this->getDoctrine()->getManager();
        $result = $em->getRepository(Lead::class)
            ->findAll();
        if (!$result) {
            $this->addFlash('success', 'There are no created lead');
            return $this->render('lead/all.html.twig');
        } else {
            return $this->render('lead/all.html.twig', ['lead' => $result]);
        }
    }




    /**
     * @Route("/lead/{id}", name="getlead")
     * @param                 $id
     * @return                Response
     */
    public function getlead($id)
    {
        $lead = $this->getDoctrine()
        ->getRepository(Lead::class)
        ->findOneByID($id);


        if (!$lead) {
            $this->addFlash('error', 'Lead not found');
            return $this->redirectToRoute('lead');
        } else {
            $createdby = $this->getDoctrine()
          ->getRepository(User::class)
          ->findOneByID($lead->getCreatedBy());

            return $this->render('lead/view.html.twig', ['lead' => $lead, 'createdby' => $createdby]);
        }
    }

    /**
     * @Route("/lead/del/{id}", name="dellead")
     * @param                 $id
     * @return                Response
     */
    public function dellead($id)
    {
        $Lead = $this->getDoctrine()
    ->getRepository(Lead::class)
    ->findOneByID($id);

        if (!$Lead) {
            $this->addFlash('error', 'Can not find lead');
            return $this->redirectToRoute('getAlllead');
        } else {
            $em = $this->getDoctrine()->getManager();
            $em->remove($Lead);
            $em->flush();
            $this->addFlash('success', 'lead sucessfully removed');
            return $this->redirectToRoute('getAlllead');
        }
    }
}
