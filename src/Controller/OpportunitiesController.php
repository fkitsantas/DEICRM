<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Opportunities;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Form\FormData;
use App\Form\Opportunities\OpportunitiesForm;
use App\Form\Opportunities\OpportunitiesEdit;
use App\Form\Opportunities\OpportunitiesSearchForm;

class OpportunitiesController extends AbstractController
{
    /**
     * @Route("/opportunities", name="opportunities")
     */
    public function index(Request $request)
    {
        $FormData = new FormData();
        $form = $this->createForm(opportunitiesSearchForm::class, $FormData);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $opportunities = $this->getDoctrine()
    ->getRepository(Opportunities::class)
    ->findByOpportunityName($data->Search);

            if (!$opportunities) {
                $this->addFlash('error', 'No opportunities was found, Try Searching Again');
                return $this->render('opportunities/index.html.twig', array('form' => $form->createView()));
            } else {
                return $this->render('opportunities/index.html.twig', array('form' => $form->createView(), 'opportunities' => $opportunities, 'searchfor' => $data->Search));
            }
        }

        return $this->render('opportunities/index.html.twig', [ 'form' => $form->createView()]);
    }

    /**
     * @Route("/opportunities/create", name="createopportunities")
     * @param           Request $request
     * @return          \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function createopportunities(Request $request)
    {
        $FormData = new FormData();
        $form = $this->createForm(OpportunitiesForm::class, $FormData);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $Opportunities = new Opportunities();
            $Opportunities->setAccountName($data->AccountName->getName());
            $Opportunities->setAccountId($data->AccountName->getId());
            $Opportunities->setCurrency($data->Currency);
            $Opportunities->setExpectedCloseDate($data->ExpectedCloseDate);
            $Opportunities->setOpportunityName($data->OpportunityName);
            $Opportunities->setOpportunityAmount($data->OpportunityAmount);
            $Opportunities->setType($data->Type);
            $Opportunities->setSalesStage($data->SalesStage);
            $Opportunities->setLeadSource($data->LeadSource);
            $Opportunities->setProbability($data->Probability);
            $Opportunities->setCampaign($data->Campaign->getName());
            $Opportunities->setCampaignId($data->Campaign->getId());
            $Opportunities->setNextStep($data->NextStep);
            $Opportunities->setDescription($data->Description);
            $Opportunities->setAssignedTo($data->AssignedTo->getUserName());
            $Opportunities->setAssignedToId($data->AssignedTo->getId());
            $Opportunities->setDateCreated(date('m/d/Y h:i:s a', time()));

            $Opportunities->setCreatedBy($this->getUser()->getId());
            $em->persist($Opportunities);
            $em->flush();

            $thisopportunities = $this->getDoctrine()
          ->getRepository(Opportunities::class)
          ->findOneByID($Opportunities->getID());

            $this->addFlash('success', 'Opportunities '.$thisopportunities->getOpportunityName().' Sucessfully Created');
            return $this->redirectToRoute('getopportunities', ['id' => $thisopportunities->getID()]);
        }


        return $this->render('opportunities/create.html.twig', array('form' => $form->createView()));
    }




    /**
     * @Route("/opportunities/edit/{id}", name="editopportunities")
     * @param           Request $request
     * @return          \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function editopportunities(Request $request, $id)
    {
        $Opportunities = $this->getDoctrine()
      ->getRepository(Opportunities::class)
      ->findOneByID($id);



        if (!$Opportunities) {
            $this->addFlash('error', 'This opportunities does not exist');

            return $this->render('opportunities/index.html.twig');
        }


        $form = $this->createForm(OpportunitiesEdit::class, $Opportunities);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $Opportunities->setOpportunityName($data->getOpportunityName());
            $Opportunities->setCurrency($data->getCurrency());
            $Opportunities->setExpectedCloseDate($data->getExpectedCloseDate());
            $Opportunities->setOpportunityAmount($data->getOpportunityAmount());
            $Opportunities->setType($data->getType());
            $Opportunities->setSalesStage($data->getSalesStage());
            $Opportunities->setLeadSource($data->getLeadSource());
            $Opportunities->setProbability($data->getProbability());
            $Opportunities->setNextStep($data->getNextStep());
            $Opportunities->setDescription($data->getDescription());
            $Opportunities->setDateModified(date('m/d/Y h:i:s a', time()));
            $em->persist($Opportunities);
            $em->flush();


            $thisopportunities = $this->getDoctrine()
          ->getRepository(Opportunities::class)
          ->findOneByID($Opportunities->getID());

            $this->addFlash('success', 'Opportunities '.$thisopportunities->getOpportunityName().' Sucessfully Edited');
            return $this->redirectToRoute('getopportunities', ['id' => $thisopportunities->getID()]);
        }


        return $this->render('opportunities/edit.html.twig', array('form' => $form->createView()));
    }




    /**
     * @Route("/opportunities/all", name="getAllopportunities")
     * @return                Response
     */
    public function getAllopportunities()
    {
        $em = $this->getDoctrine()->getManager();
        $result = $em->getRepository(Opportunities::class)
            ->findAll();
        if (!$result) {
            $this->addFlash('success', 'There are no created opportunities');
            return $this->render('opportunities/all.html.twig');
        } else {
            return $this->render('opportunities/all.html.twig', ['opportunities' => $result]);
        }
    }




    /**
     * @Route("/opportunities/{id}", name="getopportunities")
     * @param                 $id
     * @return                Response
     */
    public function getopportunities($id)
    {
        $opportunities = $this->getDoctrine()
        ->getRepository(Opportunities::class)
        ->findOneByID($id);


        if (!$opportunities) {
            $this->addFlash('error', 'Opportunities not found');
            return $this->redirectToRoute('opportunities');
        } else {
            $createdby = $this->getDoctrine()
          ->getRepository(User::class)
          ->findOneByID($opportunities->getCreatedBy());

            return $this->render('opportunities/view.html.twig', ['opportunities' => $opportunities, 'createdby' => $createdby]);
        }
    }

    /**
     * @Route("/opportunities/del/{id}", name="delopportunities")
     * @param                 $id
     * @return                Response
     */
    public function delopportunities($id)
    {
        $Opportunities = $this->getDoctrine()
    ->getRepository(Opportunities::class)
    ->findOneByID($id);

        if (!$Opportunities) {
            $this->addFlash('error', 'Can not find opportunities');
            return $this->redirectToRoute('getAllopportunities');
        } else {
            $em = $this->getDoctrine()->getManager();
            $em->remove($Opportunities);
            $em->flush();
            $this->addFlash('success', 'opportunities sucessfully removed');
            return $this->redirectToRoute('getAllopportunities');
        }
    }
}
