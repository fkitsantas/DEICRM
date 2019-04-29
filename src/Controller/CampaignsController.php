<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Campaigns;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Form\FormData;
use App\Form\Campaigns\CampaignsForm;
use App\Form\Campaigns\CampaignsEdit;
use App\Form\Campaigns\CampaignsSearchForm;

class CampaignsController extends AbstractController
{
    /**
     * @Route("/campaigns", name="campaigns")
     */
    public function index(Request $request)
    {
        $FormData = new FormData();
        $form = $this->createForm(campaignsSearchForm::class, $FormData);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $campaigns = $this->getDoctrine()
    ->getRepository(Campaigns::class)
    ->findByName($data->Search);

            if (!$campaigns) {
                $this->addFlash('error', 'No campaigns was found, Try Searching Again');
                return $this->render('campaigns/index.html.twig', array('form' => $form->createView()));
            } else {
                return $this->render('campaigns/index.html.twig', array('form' => $form->createView(), 'campaigns' => $campaigns, 'searchfor' => $data->Search));
            }
        }

        return $this->render('campaigns/index.html.twig', [ 'form' => $form->createView()]);
    }

    /**
     * @Route("/campaigns/create", name="createcampaigns")
     * @param           Request $request
     * @return          \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function createcampaigns(Request $request)
    {
        $FormData = new FormData();
        $form = $this->createForm(CampaignsForm::class, $FormData);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $Campaigns = new Campaigns();
            $Campaigns->setName($data->Name);
            $Campaigns->setStatus($data->Status);
            $Campaigns->setStartDate($data->StartDate);
            $Campaigns->setEndDate($data->EndDate);
            $Campaigns->setCurrency($data->Currency);
            $Campaigns->setActualCost($data->ActualCost);
            $Campaigns->setExpectedCost($data->ExpectedCost);
            $Campaigns->setExpectedRevenue($data->ExpectedRevenue);
            $Campaigns->setObjective($data->Objective);
            $Campaigns->setDescription($data->Description);
            $Campaigns->setImpressions($data->Impressions);
            $Campaigns->setDescription($data->Description);
            $Campaigns->setAssignedTo($data->AssignedTo->getUserName());
            $Campaigns->setAssignedToId($data->AssignedTo->getId());
            $Campaigns->setDateCreated(date('m/d/Y h:i:s a', time()));
            $Campaigns->setCreatedBy($this->getUser()->getId());
            $em->persist($Campaigns);
            $em->flush();


            $thiscampaigns = $this->getDoctrine()
          ->getRepository(Campaigns::class)
          ->findOneByID($Campaigns->getID());

            $this->addFlash('success', 'Campaigns '.$thiscampaigns->getName().' Sucessfully Created');
            return $this->redirectToRoute('getcampaigns', ['id' => $thiscampaigns->getID()]);
        }


        return $this->render('campaigns/create.html.twig', array('form' => $form->createView()));
    }




    /**
     * @Route("/campaigns/edit/{id}", name="editcampaigns")
     * @param           Request $request
     * @return          \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function editcampaigns(Request $request, $id)
    {
        $Campaigns = $this->getDoctrine()
      ->getRepository(Campaigns::class)
      ->findOneByID($id);



        if (!$Campaigns) {
            $this->addFlash('error', 'This campaigns does not exist');

            return $this->render('campaigns/index.html.twig');
        }


        $form = $this->createForm(CampaignsEdit::class, $Campaigns);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $Campaigns->setName($data->getName());
            $Campaigns->setStatus($data->getStatus());
            $Campaigns->setStartDate($data->getStartDate());
            $Campaigns->setEndDate($data->getEndDate());
            $Campaigns->setCurrency($data->getCurrency());
            $Campaigns->setActualCost($data->getActualCost());
            $Campaigns->setExpectedCost($data->getExpectedCost());
            $Campaigns->setExpectedRevenue($data->getExpectedRevenue());
            $Campaigns->setObjective($data->getObjective());
            $Campaigns->setDescription($data->getDescription());
            $Campaigns->setImpressions($data->getImpressions());
            $Campaigns->setDescription($data->getDescription());
            $Campaigns->setAssignedTo($data->getAssignedTo());
            $Campaigns->setDateModified(date('m/d/Y h:i:s a', time()));
            $em->persist($Campaigns);
            $em->flush();

            $thiscampaigns = $this->getDoctrine()
          ->getRepository(Campaigns::class)
          ->findOneByID($Campaigns->getID());

            $this->addFlash('success', 'Campaigns '.$thiscampaigns->getName().' Sucessfully Edited');
            return $this->redirectToRoute('getcampaigns', ['id' => $thiscampaigns->getID()]);
        }


        return $this->render('campaigns/edit.html.twig', array('form' => $form->createView()));
    }




    /**
     * @Route("/campaigns/all", name="getAllcampaigns")
     * @return                Response
     */
    public function getAllcampaigns()
    {
        $em = $this->getDoctrine()->getManager();
        $result = $em->getRepository(Campaigns::class)
            ->findAll();
        if (!$result) {
            $this->addFlash('success', 'There are no created campaigns');
            return $this->render('campaigns/all.html.twig');
        } else {
            return $this->render('campaigns/all.html.twig', ['campaigns' => $result]);
        }
    }




    /**
     * @Route("/campaigns/{id}", name="getcampaigns")
     * @param                 $id
     * @return                Response
     */
    public function getcampaigns($id)
    {
        $campaigns = $this->getDoctrine()
        ->getRepository(Campaigns::class)
        ->findOneByID($id);


        if (!$campaigns) {
            $this->addFlash('error', 'Campaigns not found');
            return $this->redirectToRoute('campaigns');
        } else {
            $createdby = $this->getDoctrine()
          ->getRepository(User::class)
          ->findOneByID($campaigns->getCreatedBy());

            return $this->render('campaigns/view.html.twig', ['campaigns' => $campaigns, 'createdby' => $createdby]);
        }
    }

    /**
     * @Route("/campaigns/del/{id}", name="delcampaigns")
     * @param                 $id
     * @return                Response
     */
    public function delcampaigns($id)
    {
        $Campaigns = $this->getDoctrine()
    ->getRepository(Campaigns::class)
    ->findOneByID($id);

        if (!$Campaigns) {
            $this->addFlash('error', 'Can not find campaigns');
            return $this->redirectToRoute('getAllcampaigns');
        } else {
            $em = $this->getDoctrine()->getManager();
            $em->remove($Campaigns);
            $em->flush();
            $this->addFlash('success', 'campaigns sucessfully removed');
            return $this->redirectToRoute('getAllcampaigns');
        }
    }
}
