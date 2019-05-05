<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Task;
use App\Form\TaskForm;
use App\Repository\TaskRepository;

class CalendarController extends AbstractController
{


    /**
     * Display the calendar on the frontend
     * @Route("/calendar", name="calendar", methods={"GET"})
     */
    public function calendar(): Response
    {
        return $this->render('calendar/calendar.html.twig');
    }

    /**
     * Shows specific days in the calendar
     * @Route("/calendar/{id}", name="calendar_show", methods={"GET"})
     */
    public function show(Task $task): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('calendar/show.html.twig', [
            'task' => $task,
        ]);
    }
}
