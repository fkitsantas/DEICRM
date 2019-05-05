<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Form\FormData;
use App\Form\Task\TaskForm;
use App\Form\Task\TaskEdit;
use App\Form\Task\TaskSearchForm;
use App\Entity\Task;
use App\Entity\User;
use App\Entity\Meeting;
use App\Entity\Contact;
use App\Entity\Account;
use App\Entity\Target;
use App\Entity\Lead;
use App\Entity\Opportunities;
use App\Entity\Campaigns;

class TaskController extends AbstractController
{
    /**
     * View for task
     * @Route("/task", name="task")
     */
    public function index(Request $request)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $FormData = new FormData();
        $form = $this->createForm(taskSearchForm::class, $FormData);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $task = $this->getDoctrine()
    ->getRepository(Task::class)
    ->findByOpportunityName($data->Search);


            if (!$task) {
                $this->addFlash('error', 'No task was found, Try Searching Again');
                return $this->render('task/index.html.twig', array('form' => $form->createView()));
            } else {
                return $this->render('task/index.html.twig', array('form' => $form->createView(), 'task' => $task, 'searchfor' => $data->Search));
            }
        }

        return $this->render('task/index.html.twig', [ 'form' => $form->createView()]);
    }


    /**
     * Create new task.
     * @Route("/task/create", name="createtask")
     * @param           Request $request
     * @return          \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function createtask(Request $request)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        if (!$this->isGranted('ROLE_ADMIN') && !$this->isGranted('ROLE_MANAGER')) {
            $this->addFlash('error', 'You dont have permission to acccess this page');

            return $this->redirectToRoute('task');
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
        $form = $this->createForm(TaskForm::class, $FormData);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $data = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $Task = new Task();
            $Task->setSubject($data->Subject);
            $Task->setStartDate($data->StartDate);
            $Task->setDueDate($data->DueDate);
            $Task->setPriority($data->Priority);

            $Task->setDescription($data->Description);
            if (!is_null($data->AssignedTo)) {
                $Task->setAssignedTo($data->AssignedTo->getFirstName());
                $Task->setAssignedToId($data->AssignedTo->getId());
            }

            if (!is_null($data->ContactName)) {
                $Task->setContactName($data->ContactName->getFirstName());
            }

            if (!is_null($request->request->get('RelatedTo'))) {
                $RelatedToId = $request->request->get('RelatedTo');
                $RelatedToType = $request->request->get('RelatedToType');
                $RelatedToValue = $request->request->get('RelatedToValue');

                $Task->setRelatedToId($RelatedToId);
                $Task->setRelatedToType($RelatedToType);
                $Task->setRelatedTo($RelatedToValue);
            }


            $Task->setStatus($data->Status);
            $Task->setDateCreated(date('m/d/Y h:i:s a', time()));
            $Task->setCreatedBy($this->getUser()->getId());
            $em->persist($Task);
            $em->flush();

            $thistask = $this->getDoctrine()
          ->getRepository(Task::class)
          ->findOneByID($Task->getID());


            $this->addFlash('success', 'Task '.$thistask->getSubject().' Sucessfully Created');
            return $this->redirectToRoute('gettask', ['id' => $thistask->getID()]);
        }


        return $this->render('Task/create.html.twig', array('form' => $form->createView(), 'tasks' => $tasks,  'leads' => $leads,  'meeting' => $meeting, 'contact' => $contact, 'target' => $target, 'opportunities' => $opportunities, 'campaigns' => $campaign, 'account' => $account));
    }




    /**
     * Edit task.
     * @Route("/task/edit/{id}", name="edittask")
     * @param           Request $request
     * @return          \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function edittask(Request $request, $id)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $Task = $this->getDoctrine()
      ->getRepository(Task::class)
      ->findOneByID($id);



        if (!$Task) {
            $this->addFlash('error', 'This task does not exist');

            return $this->render('task/index.html.twig');
        }


        if (!$this->isGranted('ROLE_ADMIN') && !$this->isGranted('ROLE_MANAGER') && $this->getUser()->getId() !== $Task->getAssignedToId()) {
            $this->addFlash('error', 'You dont have permission to acccess this page');

            return $this->redirectToRoute('task');
        }


        $form = $this->createForm(TaskEdit::class, $Task);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $Task->setSubject($data->getSubject());
            $Task->setStartDate($data->getStartDate());
            $Task->setDueDate($data->getDueDate());
            $Task->setPriority($data->getPriority());

            if (!is_null($form->get('ContactName')->getData())) {
                $Task->setContactName($form->get('ContactName')->getData()->getFirstName());
            }


            $Task->setDescription($data->getDescription());
            if (!is_null($form->get('AssignedTo')->getData())) {
                $Task->setAssignedTo($form->get('AssignedTo')->getData()->getFirstName());
                $Task->setAssignedToId($form->get('AssignedTo')->getData()->getId());
            }
            //$Task->setRelatedToType($data->getRelatedToType());
            //$Task->setRelatedTo($data->getRelatedTo());
            $Task->setStatus($data->getStatus());
            $Task->setDateModified(date('m/d/Y h:i:s a', time()));
            $Task->setCreatedBy($this->getUser()->getId());
            $em->persist($Task);
            $em->flush();

            $thistask = $this->getDoctrine()
          ->getRepository(Task::class)
          ->findOneByID($Task->getID());

            $this->addFlash('success', 'Task '.$thistask->getSubject().' Sucessfully Edited');
            return $this->redirectToRoute('gettask', ['id' => $thistask->getID()]);
        }


        return $this->render('Task/edit.html.twig', array('form' => $form->createView()));
    }




    /**
     * @Route("/task/all", name="getAlltask")
     * @return                Response
     */
    public function getAlltask()
    {
        $em = $this->getDoctrine()->getManager();
        $result = $em->getRepository(Task::class)
            ->findAll();
        if (!$result) {
            $this->addFlash('success', 'There are no created task');
            return $this->render('Task/all.html.twig');
        } else {
            return $this->render('Task/all.html.twig', ['task' => $result]);
        }
    }




    /**
     * View single instance of task.
     * @Route("/task/{id}", name="gettask")
     * @param                 $id
     * @return                Response
     */
    public function gettask($id)
    {
        $task = $this->getDoctrine()
        ->getRepository(Task::class)
        ->findOneByID($id);


        if (!$task) {
            $this->addFlash('error', 'Task not found');
            return $this->redirectToRoute('task');
        } else {
            $createdby = $this->getDoctrine()
          ->getRepository(User::class)
          ->findOneByID($task->getCreatedBy());

            return $this->render('Task/view.html.twig', ['task' => $task, 'createdby' => $createdby]);
        }
    }

    /**
     * Delete a task
     * @Route("/task/del/{id}", name="deltask")
     * @param                 $id
     * @return                Response
     */
    public function deltask($id)
    {
        $Task = $this->getDoctrine()
    ->getRepository(Task::class)
    ->findOneByID($id);

        if (!$Task) {
            $this->addFlash('error', 'Can not find task');
            return $this->redirectToRoute('getAlltask');
        } else {
            $em = $this->getDoctrine()->getManager();
            $em->remove($Task);
            $em->flush();
            $this->addFlash('success', 'task sucessfully removed');
            return $this->redirectToRoute('getAlltask');
        }
    }
}
