<?php


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Task;
use App\Entity\User;
use App\Entity\Contact;
use App\Entity\Campaigns;
use App\Entity\Target;
use App\Entity\Meeting;
use App\Entity\Opportunity;
use App\Entity\Lead;

class DashBoardController extends AbstractController
{
    /**
     * @Route("/dashboard", name="dashboard")
     */
    public function index()
    {
        $em = $this->getDoctrine()->getManager();
        $task = $em->getRepository(Task::class)->findAll();
        $meeting = $em->getRepository(Meeting::class)->findAll();
        $contact = $em->getRepository(Contact::class)->findAll();
        $target = $em->getRepository(Target::class)->findAll();
        $campaign = $em->getRepository(Campaigns::class)->findAll();
        $lead = $em->getRepository(Lead::class)->findAll();

        return $this->render('dashboard/index.html.twig', [
            'task' => $task, 'meeting' => $meeting, 'contact' => $contact, 'target' => $target, 'campaign' => $campaign
        ]);
    }
}
