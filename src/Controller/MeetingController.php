<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Meeting;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Form\FormData;
use App\Form\Meeting\MeetingForm;
use App\Form\Meeting\MeetingEdit;
use App\Form\Meeting\MeetingSearchForm;
use App\Entity\Task;
use App\Entity\User;
use App\Entity\Contact;
use App\Entity\Account;
use App\Entity\Target;
use App\Entity\Lead;
use App\Entity\Opportunities;
use App\Entity\Campaigns;

class MeetingController extends AbstractController
{
    /**
     * View for meeting and searchbox
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

        return $this->render('meeting/index.html.twig', ['form' => $form->createView()]);
    }


    /**
     * Store a new instance of meeting.
     * @Route("/meeting/create", name="createmeeting")
     * @param           Request $request
     * @return          \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function createmeeting(Request $request)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        if (!$this->isGranted('ROLE_ADMIN') && !$this->isGranted('ROLE_MANAGER')) {
            $this->addFlash('error', 'You dont have permission to acccess this page');

            return $this->redirectToRoute('meeting');
        }


        $tasks = $this->getDoctrine()->getRepository(Task::class)->findAll();
        $meeting = $this->getDoctrine()->getRepository(Meeting::class)->findAll();
        $contact = $this->getDoctrine()->getRepository(Contact::class)->findAll();
        $leads = $this->getDoctrine()->getRepository(Lead::class)->findAll();
        $account = $this->getDoctrine()->getRepository(Account::class)->findAll();
        $target = $this->getDoctrine()->getRepository(Target::class)->findAll();
        $campaign = $this->getDoctrine()->getRepository(Campaigns::class)->findAll();
        $opportunities = $this->getDoctrine()->getRepository(Opportunities::class)->findAll();


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

            $Meeting->setDescription($data->Description);

            if (!is_null($data->AssignedTo)) {
                $Meeting->setAssignedTo($data->AssignedTo->getFirstName());
                $Meeting->setAssignedToId($data->AssignedTo->getId());
            }
            if (!is_null($data->ContactName)) {
                $Meeting->setContactName($data->ContactName->getFirstName());
            }

            if (!is_null($request->request->get('RelatedTo'))) {
                $RelatedToId = $request->request->get('RelatedTo');
                $RelatedToType = $request->request->get('RelatedToType');
                $RelatedToValue = $request->request->get('RelatedToValue');

                $Meeting->setRelatedToId($RelatedToId);
                $Meeting->setRelatedToType($RelatedToType);
                $Meeting->setRelatedTo($RelatedToValue);
            }
            $Meeting->setStatus($data->Status);
            $Meeting->setDateCreated(date('m/d/Y h:i:s a', time()));
            $Meeting->setCreatedBy($this->getUser()->getId());
            $em->persist($Meeting);
            $em->flush();

            $thismeeting = $this->getDoctrine()
                ->getRepository(Meeting::class)
                ->findOneByID($Meeting->getID());

            $this->addFlash('success', 'Meeting ' . $thismeeting->getSubject() . ' Sucessfully Created');
            return $this->redirectToRoute('getmeeting', ['id' => $thismeeting->getID()]);
        }


        return $this->render('meeting/create.html.twig', array('form' => $form->createView(), 'tasks' => $tasks, 'leads' => $leads, 'meeting' => $meeting, 'contact' => $contact, 'target' => $target, 'opportunities' => $opportunities, 'campaigns' => $campaign, 'account' => $account));
    }


    /**
     * Edit an instance of meeting.
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

        if (!$this->isGranted('ROLE_ADMIN') && !$this->isGranted('ROLE_MANAGER') && $this->getUser()->getId() !== $Meeting->getAssignedToId()) {
            $this->addFlash('error', 'You dont have permission to acccess this page');

            return $this->redirectToRoute('meeting');
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
            if (!is_null($form->get('ContactName')->getData())) {
                $Meeting->setContactName($form->get('ContactName')->getData()->getFirstName());
            }
            $Meeting->setDescription($data->getDescription());
            if (!is_null($form->get('AssignedTo')->getData())) {
                $Meeting->setAssignedTo($form->get('AssignedTo')->getData()->getFirstName());
                $Meeting->setAssignedToId($form->get('AssignedTo')->getData()->getId());
            }
            //$Meeting->setRelatedToType($data->getRelatedToType());
            //$Meeting->setRelatedTo($data->getRelatedTo());
            $Meeting->setStatus($data->getStatus());
            $Meeting->setDateModified(date('m/d/Y h:i:s a', time()));
            $Meeting->setCreatedBy($this->getUser()->getId());
            $em->persist($Meeting);
            $em->flush();

            $thismeeting = $this->getDoctrine()
                ->getRepository(Meeting::class)
                ->findOneByID($Meeting->getID());

            $this->addFlash('success', 'Meeting ' . $thismeeting->getSubject() . ' Sucessfully Edited');
            return $this->redirectToRoute('getmeeting', ['id' => $thismeeting->getID()]);
        }


        return $this->render('meeting/edit.html.twig', array('form' => $form->createView()));
    }


    /**
     * Fetch all meetings.
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
            return $this->render('meeting/all.html.twig');
        } else {
            return $this->render('meeting/all.html.twig', ['meeting' => $result]);
        }
    }


    /**
     * Fetch an instance of meeting
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

            return $this->render('meeting/view.html.twig', ['meeting' => $meeting, 'createdby' => $createdby]);
        }
    }

    /**
     * Delete an instance of meeting.
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
