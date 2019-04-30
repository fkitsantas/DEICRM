<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Meeting;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Form\FormData;
use App\Form\Meeting\MeetingForm;
use App\Form\Meeting\MeetingEdit;
use App\Form\Meeting\MeetingSearchForm;

class MeetingController extends AbstractController
{
    /**
     * @Route("/meeting", name="meeting")
     */
    public function index(Request $request)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $FormData = new FormData();
        $form = $this->createForm(meetingSearchForm::class, $FormData);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $meeting = $this->getDoctrine()
    ->getRepository(Meeting::class)
    ->findByOpportunityName($data->Search);

            if (!$meeting) {
                $this->addFlash('error', 'No meeting was found, Try Searching Again');
                return $this->render('meeting/index.html.twig', array('form' => $form->createView()));
            } else {
                return $this->render('meeting/index.html.twig', array('form' => $form->createView(), 'meeting' => $meeting, 'searchfor' => $data->Search));
            }
        }

        return $this->render('meeting/index.html.twig', [ 'form' => $form->createView()]);
    }


    /**
     * @Route("/meeting/create", name="createmeeting")
     * @param           Request $request
     * @return          \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function createmeeting(Request $request)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $FormData = new FormData();
        $form = $this->createForm(MeetingForm::class, $FormData);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $Meeting = new Meeting();
            $Meeting->setSubject($data->Subject);
            $Meeting->setStartDate($data->StartDate);
            $Meeting->setDueDate($data->DueDate);
            $Meeting->setLocation($data->Location);
            $Meeting->setContactName($data->ContactName->getFirstName());
            $Meeting->setDescription($data->Description);
            $Meeting->setAssignedTo($data->AssignedTo->getUserName());
            $Meeting->setAssignedToId($data->AssignedTo->getId());
            $Meeting->setRelatedToType($data->RelatedToType);
            $Meeting->setRelatedTo($data->RelatedTo);

            $Meeting->setStatus($data->Status);
            $Meeting->setDateCreated(date('m/d/Y h:i:s a', time()));
            $Meeting->setCreatedBy($this->getUser()->getId());
            $em->persist($Meeting);
            $em->flush();

            $thismeeting = $this->getDoctrine()
          ->getRepository(Meeting::class)
          ->findOneByID($Meeting->getID());

            $this->addFlash('success', 'Meeting '.$thismeeting->getSubject().' Sucessfully Created');
            return $this->redirectToRoute('getmeeting', ['id' => $thismeeting->getID()]);
        }


        return $this->render('Meeting/create.html.twig', array('form' => $form->createView()));
    }




    /**
     * @Route("/meeting/edit/{id}", name="editmeeting")
     * @param           Request $request
     * @return          \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function editmeeting(Request $request, $id)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $Meeting = $this->getDoctrine()
      ->getRepository(Meeting::class)
      ->findOneByID($id);



        if (!$Meeting) {
            $this->addFlash('error', 'This meeting does not exist');

            return $this->render('meeting/index.html.twig');
        }


        $form = $this->createForm(MeetingEdit::class, $Meeting);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $Meeting->setSubject($data->getSubject());
            $Meeting->setStartDate($data->getStartDate());
            $Meeting->setDueDate($data->getDueDate());
            $Meeting->setLocation($data->getLocation());
            $Meeting->setContactName($data->getContactName->getFirstName());
            $Meeting->setDescription($data->getDescription());
            $Meeting->setAssignedTo($data->getAssignedTo->getUserName());
            $Meeting->setAssignedToId($data->getAssignedTo->getId());
            $Meeting->setRelatedToType($data->getRelatedToType());
            $Meeting->setRelatedTo($data->getRelatedTo());
            $Meeting->setStatus($data->getStatus());
            $Meeting->setDateModified(date('m/d/Y h:i:s a', time()));
            $Meeting->setCreatedBy($this->getUser()->getId());
            $em->persist($Meeting);
            $em->flush();

            $thismeeting = $this->getDoctrine()
          ->getRepository(Meeting::class)
          ->findOneByID($Meeting->getID());

            $this->addFlash('success', 'Meeting '.$thismeeting->getSubject().' Sucessfully Edited');
            return $this->redirectToRoute('getmeeting', ['id' => $thismeeting->getID()]);
        }


        return $this->render('Meeting/edit.html.twig', array('form' => $form->createView()));
    }




    /**
     * @Route("/meeting/all", name="getAllmeeting")
     * @return                Response
     */
    public function getAllmeeting()
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $em = $this->getDoctrine()->getManager();
        $result = $em->getRepository(Meeting::class)
            ->findAll();
        if (!$result) {
            $this->addFlash('success', 'There are no created meeting');
            return $this->render('Meeting/all.html.twig');
        } else {
            return $this->render('Meeting/all.html.twig', ['meeting' => $result]);
        }
    }




    /**
     * @Route("/meeting/{id}", name="getmeeting")
     * @param                 $id
     * @return                Response
     */
    public function getmeeting($id)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $meeting = $this->getDoctrine()
        ->getRepository(Meeting::class)
        ->findOneByID($id);


        if (!$meeting) {
            $this->addFlash('error', 'Meeting not found');
            return $this->redirectToRoute('meeting');
        } else {
            $createdby = $this->getDoctrine()
          ->getRepository(User::class)
          ->findOneByID($meeting->getCreatedBy());

            return $this->render('Meeting/view.html.twig', ['meeting' => $meeting, 'createdby' => $createdby]);
        }
    }

    /**
     * @Route("/meeting/del/{id}", name="delmeeting")
     * @param                 $id
     * @return                Response
     */
    public function delmeeting($id)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $Meeting = $this->getDoctrine()
    ->getRepository(Meeting::class)
    ->findOneByID($id);

        if (!$Meeting) {
            $this->addFlash('error', 'Can not find meeting');
            return $this->redirectToRoute('getAllmeeting');
        } else {
            $em = $this->getDoctrine()->getManager();
            $em->remove($Meeting);
            $em->flush();
            $this->addFlash('success', 'meeting sucessfully removed');
            return $this->redirectToRoute('getAllmeeting');
        }
    }
}
