<?php


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Task;
use App\Entity\User;
use App\Entity\Contact;
use App\Entity\Campaigns;
use App\Entity\Account;
use App\Entity\Target;
use App\Entity\Meeting;
use App\Entity\Cases;
use App\Entity\Lead;
use App\Entity\Opportunities;
use App\Entity\Note;
use App\Entity\Document;
use App\Service\RolesToText;

class DashBoardController extends AbstractController
{
    /**
     * Dashboard for admininstrator, manager and Employees, does two things
     * 1) Makes all record visible to the administrator
     * 2) Shows assigned records to manager and employee
     * @Route("/dashboard", name="dashboard")
     */
    public function index(RolesToText $rolesToText)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $em = $this->getDoctrine()->getManager();
        $task = $em->getRepository(Task::class)->findBy(
            array(),
            array('id' => 'DESC')
        );
        $meeting = $em->getRepository(Meeting::class)->findBy(
            array(),
            array('id' => 'DESC')
        );
        $contact = $em->getRepository(Contact::class)->findBy(
            array(),
            array('id' => 'DESC')
        );
        $account = $em->getRepository(Account::class)->findBy(
            array(),
            array('id' => 'DESC')
        );
        $target = $em->getRepository(Target::class)->findBy(
            array(),
            array('id' => 'DESC')
        );
        $campaign = $em->getRepository(Campaigns::class)->findBy(
            array(),
            array('id' => 'DESC')
        );
        $lead = $em->getRepository(Lead::class)->findBy(
            array(),
            array('id' => 'DESC')
        );
        $users = $em->getRepository(User::class)->findBy(
            array(),
            array('id' => 'DESC')
        );
        $opportunities = $em->getRepository(Opportunities::class)->findBy(
            array(),
            array('id' => 'DESC')
        );
        $note = $em->getRepository(Note::class)->findBy(
            array(),
            array('id' => 'DESC')
        );
        $document = $em->getRepository(Document::class)->findBy(
            array(),
            array('id' => 'DESC')
        );


        $cases = $em->getRepository(Cases::class)->findBy(
            array(),
            array('id' => 'DESC')
        );


        $assignedopportunities = $this->getDoctrine()->getRepository(Opportunities::class)->findBy(
            ['AssignedToId' => $this->getUser()->getId()]
        );


        $assignedcases = $this->getDoctrine()->getRepository(Cases::class)->findBy(
            ['AssignedToId' => $this->getUser()->getId()]
        );

        $assignedtask = $this->getDoctrine()->getRepository(Task::class)->findBy(
            ['AssignedToId' => $this->getUser()->getId()]
        );

        $assignedlead = $this->getDoctrine()->getRepository(Lead::class)->findBy(
            ['AssignedToId' => $this->getUser()->getId()]
        );

        $assignedmeeting = $this->getDoctrine()->getRepository(Meeting::class)->findBy(
            ['AssignedToId' => $this->getUser()->getId()]
        );


        $assignednote = $this->getDoctrine()->getRepository(Note::class)->findBy(
            ['AssignedToId' => $this->getUser()->getId()]
        );

        $assignedtarget = $this->getDoctrine()->getRepository(Target::class)->findBy(
            ['AssignedToId' => $this->getUser()->getId()]
        );

        $assigneddocument = $this->getDoctrine()->getRepository(Document::class)->findBy(
            ['AssignedToId' => $this->getUser()->getId()]
        );

        $assignedcampaign = $this->getDoctrine()->getRepository(Campaigns::class)->findBy(
            ['AssignedToId' => $this->getUser()->getId()]
        );

        $assignedaccount = $this->getDoctrine()->getRepository(Account::class)->findBy(
            ['AssignedToId' => $this->getUser()->getId()]
        );

        $assignedcontact = $this->getDoctrine()->getRepository(Contact::class)->findBy(
            ['AssignedToId' => $this->getUser()->getId()]
        );


        $users = $rolesToText->rolesToText($users, "all");


        return $this->render('dashboard/index.html.twig', [
            'task' => $task, 'lead' => $lead, 'cases' => $cases, 'meeting' => $meeting, 'contact' => $contact, 'target' => $target, 'opportunities' => $opportunities, 'campaigns' => $campaign, 'account' => $account, 'users' => $users, 'note' => $note, 'document' => $document, 'assignedtask' => $assignedtask, 'assignedcases' => $assignedcases, 'assignedlead' => $assignedlead, 'assignedmeeting' => $assignedmeeting, 'assignedcontact' => $assignedcontact, 'assignedtarget' => $assignedtarget, 'assignedopportunities' => $assignedopportunities, 'assignedcampaigns' => $assignedcampaign, 'assignedaccount' => $assignedaccount, 'assignednote' => $assignednote, 'assigneddocument' => $assigneddocument
        ]);
    }
}
