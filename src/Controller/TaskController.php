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
        $FormData = new FormData();
        $form = $this->createForm(TaskForm::class, $FormData);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $Task = new Task();
            $Task->setStartDate($data->StartDate);
            $Task->setDueDate($data->DueDate);
            $Task->setPriority($data->Priority);
            $Task->setContactName($data->ContactName);
            $Task->setDescription($data->Description);
            $Task->setAssignedTo($data->AssignedTo->getUserName());
            $Task->setAssignedToId($data->AssignedTo->getId());
            $Task->setRelatedToType($data->RelatedToType);
            $Task->setRelatedTo($data->AssignedTo->getUserName());
            $Task->setRelatedToId($data->AssignedTo->getId());
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
        $Task = $this->getDoctrine()
      ->getRepository(Task::class)
      ->findOneByID($id);



        if (!$Task) {
            $this->addFlash('error', 'This task does not exist');

            return $this->render('task/index.html.twig');
        }


        $form = $this->createForm(TaskEdit::class, $Task);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $Task->getsetStartDate($data->getStartDate());
            $Task->getsetDueDate($data->getDueDate());
            $Task->getsetPriority($data->getPriority());
            $Task->getsetContactName($data->getContactName());
            $Task->getsetDescription($data->getDescription());
            $Task->getsetAssignedTo($data->getAssignedTo->getgetUserName());
            $Task->getsetAssignedToId($data->getAssignedTo->getgetId());
            $Task->getsetRelatedToType($data->getRelatedToType());
            $Task->getsetRelatedTo($data->getAssignedTo->getgetUserName());
            $Task->getsetRelatedToId($data->getAssignedTo->getgetId());
            $Task->getsetStatus($data->getStatus());
            $Task->getsetDateCreated(date('m/d/Y h:i:s a', time()));
            $Task->getsetCreatedBy($this->getgetUser()->getgetId());
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
