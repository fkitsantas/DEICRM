<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Opportunities;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Form\FormData;
use App\Entity\Task;
use App\Entity\Note;
use App\Entity\Meeting;
use App\Form\Opportunities\OpportunitiesForm;
use App\Form\Opportunities\OpportunitiesEdit;
use App\Form\Opportunities\OpportunitiesSearchForm;

class OpportunitiesController extends AbstractController
{
    /**
     * View for OpportunitiesEdit and a searchbox to search opportunities.
     * @Route("/opportunities", name="opportunities")
     */
    public function index(Request $request)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');


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

        return $this->render('opportunities/index.html.twig', ['form' => $form->createView()]);
    }

    /**
     * Create a new Opportunity.
     * @Route("/opportunities/create", name="createopportunities")
     * @param           Request $request
     * @return          \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function createopportunities(Request $request)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        if (!$this->isGranted('ROLE_ADMIN') && !$this->isGranted('ROLE_MANAGER')) {
            $this->addFlash('error', 'You dont have permission to acccess this page');

            return $this->redirectToRoute('opportunities');
        }
        $FormData = new FormData();
        $form = $this->createForm(OpportunitiesForm::class, $FormData);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $Opportunities = new Opportunities();
            if (!is_null($data->AccountName)) {
                $Opportunities->setAccountName($data->AccountName->getName());
                $Opportunities->setAccountId($data->AccountName->getId());
            }
            $Opportunities->setCurrency($data->Currency);
            $Opportunities->setExpectedCloseDate($data->ExpectedCloseDate);
            $Opportunities->setOpportunityName($data->OpportunityName);
            $Opportunities->setOpportunityAmount($data->OpportunityAmount);
            $Opportunities->setType($data->Type);
            $Opportunities->setSalesStage($data->SalesStage);
            $Opportunities->setLeadSource($data->LeadSource);
            $Opportunities->setProbability($data->Probability);


            if (!is_null($data->ContactName)) {
                $Opportunities->setContactName($data->ContactName->getFirstName());
            }


            if (!is_null($data->Campaign)) {
                $Opportunities->setCampaign($data->Campaign->getName());
                $Opportunities->setCampaignId($data->Campaign->getId());
            }
            $Opportunities->setNextStep($data->NextStep);
            $Opportunities->setDescription($data->Description);
            if (!is_null($data->AssignedTo)) {
                $Opportunities->setAssignedTo($data->AssignedTo->getFirstName());
                $Opportunities->setAssignedToId($data->AssignedTo->getId());
            }
            $Opportunities->setDateCreated(date('m/d/Y h:i:s a', time()));

            $Opportunities->setCreatedBy($this->getUser()->getId());
            $em->persist($Opportunities);
            $em->flush();

            $thisopportunities = $this->getDoctrine()
                ->getRepository(Opportunities::class)
                ->findOneByID($Opportunities->getID());

            $this->addFlash('success', 'Opportunities ' . $thisopportunities->getOpportunityName() . ' Sucessfully Created');
            return $this->redirectToRoute('getopportunities', ['id' => $thisopportunities->getID()]);
        }


        return $this->render('opportunities/create.html.twig', array('form' => $form->createView()));
    }


    /**
     * Edit an already exisitng opportunity.
     * @Route("/opportunities/edit/{id}", name="editopportunities")
     * @param           Request $request
     * @return          \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function editopportunities(Request $request, $id)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $Opportunities = $this->getDoctrine()
            ->getRepository(Opportunities::class)
            ->findOneByID($id);


        if (!$Opportunities) {
            $this->addFlash('error', 'This opportunities does not exist');

            return $this->render('opportunities/index.html.twig');
        }

        if (!$this->isGranted('ROLE_ADMIN') && !$this->isGranted('ROLE_MANAGER') && $this->getUser()->getId() !== $Opportunities->getAssignedToId()) {
            $this->addFlash('error', 'You dont have permission to acccess this page');

            return $this->redirectToRoute('opportunities');
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

            if (!is_null($form->get('AccountName')->getData())) {
                $Opportunities->setAccountName($form->get('AccountName')->getData()->getName());
                $Opportunities->setAccountId($form->get('AccountName')->getData()->getId());
            }

            if (!is_null($form->get('AssignedTo')->getData())) {
                $Opportunities->setAssignedTo($form->get('AssignedTo')->getData()->getFirstName());
                $Opportunities->setAssignedToId($form->get('AssignedTo')->getData()->getId());
            }


            if (!is_null($form->get('ContactName')->getData())) {
                $Opportunities->setContactName($form->get('ContactName')->getData()->getFirstName());
                $Opportunities->setContactId($form->get('ContactName')->getData()->getId());
            }


            $Opportunities->setDescription($data->getDescription());
            $Opportunities->setDateModified(date('m/d/Y h:i:s a', time()));
            $em->persist($Opportunities);
            $em->flush();


            $thisopportunities = $this->getDoctrine()
                ->getRepository(Opportunities::class)
                ->findOneByID($Opportunities->getID());

            $this->addFlash('success', 'Opportunities ' . $thisopportunities->getOpportunityName() . ' Sucessfully Edited');
            return $this->redirectToRoute('getopportunities', ['id' => $thisopportunities->getID()]);
        }


        return $this->render('opportunities/edit.html.twig', array('form' => $form->createView()));
    }


    /**
     * Fetch all instance of opportunity from the database.
     * @Route("/opportunities/all", name="getAllopportunities")
     * @return                Response
     */
    public function getAllopportunities()
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
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
     * Fetch single instance of opportunity from the database.
     * @Route("/opportunities/{id}", name="getopportunities")
     * @param                 $id
     * @return                Response
     */
    public function getopportunities($id)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
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

            $taskrepository = $this->getDoctrine()->getRepository(Task::class);
            $task = $taskrepository->findBy(
                ['RelatedToType' => 'Opportunities',
                    'RelatedToId' => $id,
                ]
            );

            $noterepository = $this->getDoctrine()->getRepository(Note::class);
            $note = $noterepository->findBy(
                ['RelatedToType' => 'Opportunities',
                    'RelatedToId' => $id,
                ]
            );


            $meetingrepository = $this->getDoctrine()->getRepository(Meeting::class);
            $meeting = $meetingrepository->findBy(
                ['RelatedToType' => 'Opportunities',
                    'RelatedToId' => $id,
                ]
            );

            return $this->render('opportunities/view.html.twig', ['opportunities' => $opportunities, 'createdby' => $createdby, 'task' => $task, 'note' => $note, 'meeting' => $meeting]);
        }
    }

    /**
     * Delete opportunity.
     * @Route("/opportunities/del/{id}", name="delopportunities")
     * @param                 $id
     * @return                Response
     */
    public function delopportunities($id)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
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
