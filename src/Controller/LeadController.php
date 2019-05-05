<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Lead;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Form\FormData;
use App\Entity\Task;
use App\Entity\Note;
use App\Entity\Meeting;
use App\Form\Lead\LeadForm;
use App\Form\Lead\LeadEdit;
use App\Form\Lead\LeadSearchForm;

class LeadController extends AbstractController
{
    /**
     * View for leads with a searchbox.
     * @Route("/lead", name="lead")
     */
    public function index(Request $request)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
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

        return $this->render('lead/index.html.twig', ['form' => $form->createView()]);
    }

    /**
     * Allows creation of new lead.
     * @Route("/lead/create", name="createlead")
     * @param           Request $request
     * @return          \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function createlead(Request $request)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        if (!$this->isGranted('ROLE_ADMIN') && !$this->isGranted('ROLE_MANAGER')) {
            $this->addFlash('error', 'You dont have permission to acccess this page');

            return $this->redirectToRoute('lead');
        }
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
            if (!is_null($data->Campaign)) {
                $Lead->setCampaign($data->Campaign->getName());
                $Lead->setCampaignId($data->Campaign->getId());
            }
            if (!is_null($data->AssignedTo)) {
                $Lead->setAssignedTo($data->AssignedTo->getFirstName());
                $Lead->setAssignedToId($data->AssignedTo->getId());
            }
            $Lead->setDateCreated(date('m/d/Y h:i:s a', time()));
            $Lead->setCreatedBy($this->getUser()->getUsername());
            $em->persist($Lead);
            $em->flush();


            $thislead = $this->getDoctrine()
                ->getRepository(Lead::class)
                ->findOneByID($Lead->getID());

            $this->addFlash('success', 'Lead ' . $thislead->getLastName() . ' Sucessfully Created');
            return $this->redirectToRoute('getlead', ['id' => $thislead->getID()]);
        }


        return $this->render('lead/create.html.twig', array('form' => $form->createView()));
    }


    /**
     * Allows previously stored lead to be edited.
     * @Route("/lead/edit/{id}", name="editlead")
     * @param           Request $request
     * @return          \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function editlead(Request $request, $id)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $Lead = $this->getDoctrine()
            ->getRepository(Lead::class)
            ->findOneByID($id);


        if (!$Lead) {
            $this->addFlash('error', 'This lead does not exist');

            return $this->render('lead/index.html.twig');
        }

        if (!$this->isGranted('ROLE_ADMIN') && !$this->isGranted('ROLE_MANAGER') && $this->getUser()->getId() !== $Lead->getAssignedToId()) {
            $this->addFlash('error', 'You dont have permission to acccess this page');

            return $this->redirectToRoute('lead');
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
            if (!is_null($form->get('AssignedTo')->getData())) {
                $Lead->setAssignedTo($form->get('AssignedTo')->getData()->getFirstName());
                $Lead->setAssignedToId($form->get('AssignedTo')->getData()->getId());
            }
            $Lead->setDateCreated(date('m/d/Y h:i:s a', time()));
            $Lead->setDescription($data->getDescription());
            $Lead->setDateModified(date('m/d/Y h:i:s a', time()));
            $em->persist($Lead);
            $em->flush();


            $thislead = $this->getDoctrine()
                ->getRepository(Lead::class)
                ->findOneByID($Lead->getID());

            $this->addFlash('success', 'Lead ' . $thislead->getLastName() . ' Sucessfully Edited');
            return $this->redirectToRoute('getlead', ['id' => $thislead->getID()]);
        }


        return $this->render('lead/edit.html.twig', array('form' => $form->createView()));
    }


    /**
     * Fetch all leads from leads table.
     * @Route("/lead/all", name="getAlllead")
     * @return                Response
     */
    public function getAlllead()
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
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
     * Fetch lead from table.
     * @Route("/lead/{id}", name="getlead")
     * @param                 $id
     * @return                Response
     */
    public function getlead($id)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $lead = $this->getDoctrine()
            ->getRepository(Lead::class)
            ->findOneByID($id);


        if (!$lead) {
            $this->addFlash('error', 'Lead not found');
            return $this->redirectToRoute('lead');
        } else {
            $taskrepository = $this->getDoctrine()->getRepository(Task::class);
            $task = $taskrepository->findBy(
                ['RelatedToType' => 'Lead',
                    'RelatedToId' => $id,
                ]
            );


            $noterepository = $this->getDoctrine()->getRepository(Note::class);
            $note = $noterepository->findBy(
                ['RelatedToType' => 'Lead',
                    'RelatedToId' => $id,
                ]
            );


            $meetingrepository = $this->getDoctrine()->getRepository(Meeting::class);
            $meeting = $meetingrepository->findBy(
                ['RelatedToType' => 'Lead',
                    'RelatedToId' => $id,
                ]
            );

            return $this->render('lead/view.html.twig', ['lead' => $lead, 'task' => $task, 'note' => $note, 'meeting' => $meeting]);
        }
    }

    /**
     * Delete lead from lead table.
     * @Route("/lead/del/{id}", name="dellead")
     * @param                 $id
     * @return                Response
     */
    public function delaccount($id)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
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
