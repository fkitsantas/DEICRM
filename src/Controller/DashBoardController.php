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

use App\Entity\Lead;
use App\Entity\Opportunities;

class DashBoardController extends AbstractController
{
    /**
     * @Route("/dashboard", name="dashboard")
     */
    public function index()
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $em = $this->getDoctrine()->getManager();
        $task = $em->getRepository(Task::class)->findAll();
        $meeting = $em->getRepository(Meeting::class)->findAll();
        $contact = $em->getRepository(Contact::class)->findAll();

        $account = $em->getRepository(Account::class)->findAll();
        $target = $em->getRepository(Target::class)->findAll();
        $campaign = $em->getRepository(Campaigns::class)->findAll();
        $lead = $em->getRepository(Lead::class)->findAll();
        $users = $em->getRepository(User::class)->findAll();
        $opportunities = $em->getRepository(Opportunities::class)->findAll();

        return $this->render('dashboard/index.html.twig', [
            'task' => $task,  'lead' => $lead,  'meeting' => $meeting, 'contact' => $contact, 'target' => $target, 'opportunities' => $opportunities, 'campaigns' => $campaign,  'account' => $account, 'users' => $users
        ]);
    }
}
