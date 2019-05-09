<?php

namespace App\EventListener;

use App\Entity\Task;
use App\Repository\TaskRepository;
use App\Entity\Meeting;
use App\Repository\MeetingRepository;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use CalendarBundle\Entity\Event;
use CalendarBundle\Event\CalendarEvent;

class CalendarListener
{
    private $taskRepository;
    private $meetingRepository;
    private $router;

    public function __construct(
        TaskRepository $taskRepository,
        MeetingRepository $meetingRepository,
        UrlGeneratorInterface $router
    ) {
        $this->taskRepository = $taskRepository;
        $this->meetingRepository = $meetingRepository;
        $this->router = $router;
    }

    public function load(CalendarEvent $calendar): void
    {
        $start = $calendar->getStart();
        $end = $calendar->getEnd();
        $filters = $calendar->getFilters();

        // Modify the query to fit to your entity and needs
        // Change task.beginAt by your start date property
        $tasks = $this->taskRepository
            ->createQueryBuilder('task')
            ->where('task.StartDate BETWEEN :start and :end')
            ->setParameter('start', $start->format('Y-m-d H:i:s'))
            ->setParameter('end', $end->format('Y-m-d H:i:s'))
            ->getQuery()
            ->getResult()
        ;

        $meetings = $this->meetingRepository
            ->createQueryBuilder('meeting')
            ->where('meeting.StartDate BETWEEN :start and :end')
            ->setParameter('start', $start->format('Y-m-d H:i:s'))
            ->setParameter('end', $end->format('Y-m-d H:i:s'))
            ->getQuery()
            ->getResult()
        ;


        foreach ($tasks as $task) {
            // this create the events with your data (here task data) to fill calendar
            $taskEvent = new Event(
                $task->getSubject(),
                $task->getStartDate(),
                $task->getDueDate() // If the end date is null or not defined, a all day event is created.
            );

            /*
             * Add custom options to events
             *
             * For more information see: https://fullcalendar.io/docs/event-object
             * and: https://github.com/fullcalendar/fullcalendar/blob/master/src/core/options.ts
             */

            $taskEvent->setOptions([
                'backgroundColor' => 'blue',
                'borderColor' => 'blue',
            ]);
            $taskEvent->addOption(
                'url',
                $this->router->generate('gettask', [
                    'id' => $task->getId(),
                ])
            );

            // finally, add the event to the CalendarEvent to fill the calendar
            $calendar->addEvent($taskEvent);
        }


        foreach ($meetings as $meeting) {
            // this create the events with your data (here task data) to fill calendar
            $meetingEvent = new Event(
                $meeting->getSubject(),
                $meeting->getStartDate(),
                $meeting->getDueDate() // If the end date is null or not defined, a all day event is created.
            );

            $meetingEvent->setOptions([
                'backgroundColor' => 'green',
                'borderColor' => 'green',
            ]);
            $meetingEvent->addOption(
                'url',
                $this->router->generate('getmeeting', [
                    'id' => $meeting->getId(),
                ])
            );

            // finally, add the event to the CalendarEvent to fill the calendar
            $calendar->addEvent($meetingEvent);
        }
    }
}
