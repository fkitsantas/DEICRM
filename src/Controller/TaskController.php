<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Task;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Form\FormData;
use App\Form\Task\TaskForm;
use App\Form\Task\TaskEdit;
use App\Form\Task\TaskSearchForm;

class TaskController extends AbstractController
{
    /**
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
     * @Route("/task/create", name="createtask")
     * @param           Request $request
     * @return          \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function createtask(Request $request)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        if (!$this->isGranted('ROLE_ADMIN')) {
            $this->addFlash('error', 'You dont have permission to acccess this page');

            return $this->redirectToRoute('task');
        }




        $FormData = new FormData();
        $form = $this->createForm(TaskForm::class, $FormData);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $Task = new Task();
            $Task->setSubject($data->Subject);
            $Task->setStartDate($data->StartDate);
            $Task->setDueDate($data->DueDate);
            $Task->setPriority($data->Priority);
            $Task->setContactName($data->ContactName->getFirstName());
            $Task->setDescription($data->Description);
            $Task->setAssignedTo($data->AssignedTo->getUserName());
            $Task->setAssignedToId($data->AssignedTo->getId());
            $Task->setRelatedToType($data->RelatedToType);
            $Task->setRelatedTo($data->RelatedTo);

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


        return $this->render('Task/create.html.twig', array('form' => $form->createView()));
    }




    /**
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


        if (!$this->isGranted('ROLE_ADMIN') || $this->getUser()->getId() !== $Task->getAssignedToId()) {
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
            //$Task->setContactName($data->getContactName->getFirstName());
            $Task->setDescription($data->getDescription());
            //$Task->setAssignedTo($data->getAssignedTo->getUserName());
            //$Task->setAssignedToId($data->getAssignedTo->getId());
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
