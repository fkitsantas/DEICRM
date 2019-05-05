<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Email;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Form\FormData;
use App\Form\Email\EmailForm;
use App\Form\Email\EmailSearchForm;

use App\Entity\User;
use App\Entity\Contact;
use App\Entity\Account;
use App\Entity\Target;
use App\Entity\Lead;

class EmailController extends AbstractController
{
    /**
     * Email view with a searcbox.
     * @Route("/email", name="email")
     */
    public function index(Request $request)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $FormData = new FormData();
        $form = $this->createForm(emailSearchForm::class, $FormData);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $email = $this->getDoctrine()
                ->getRepository(Email::class)
                ->findByOpportunityName($data->Search);

            if (!$email) {
                $this->addFlash('error', 'No email was found, Try Searching Again');
                return $this->render('email/index.html.twig', array('form' => $form->createView()));
            } else {
                return $this->render('email/index.html.twig', array('form' => $form->createView(), 'email' => $email, 'searchfor' => $data->Search));
            }
        }

        return $this->render('email/index.html.twig', ['form' => $form->createView()]);
    }


    /**
     * Allows sending of mails to accounts, contacts, leads, targets.
     * @Route("/email/create", name="createemail")
     * @param           Request $request
     * @return          \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function createemail(Request $request)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        if (!$this->isGranted('ROLE_ADMIN') && !$this->isGranted('ROLE_MANAGER')) {
            $this->addFlash('error', 'You dont have permission to acccess this page');

            return $this->redirectToRoute('email');
        }


        $email = $this->getDoctrine()->getRepository(Email::class)->findAll();
        $contact = $this->getDoctrine()->getRepository(Contact::class)->findAll();
        $leads = $this->getDoctrine()->getRepository(Lead::class)->findAll();
        $account = $this->getDoctrine()->getRepository(Account::class)->findAll();
        $target = $this->getDoctrine()->getRepository(Target::class)->findAll();


        $FormData = new FormData();
        $form = $this->createForm(EmailForm::class, $FormData);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            //$message = (new \Swift_Message('Hello Email'))
            //->setFrom('send@example.com')
            //->setTo('recipient@example.com')
            //->setBody($data->$message, 'text/plain')
            //;

            //$mailer->send($message);

            $em = $this->getDoctrine()->getManager();
            $Email = new Email();
            $Email->setSubject($data->Subject);

            $Email->setMessage($data->Message);

            $Email->setType($data->Type);

            $Email->setCreatedBy($this->getUser()->getId());

            $Email->setSentDate(date('m/d/Y h:i:s a', time()));
            $em->persist($Email);
            $em->flush();

            $thisemail = $this->getDoctrine()
                ->getRepository(Email::class)
                ->findOneByID($Email->getId());

            $this->addFlash('success', 'Email ' . $thisemail->getSubject() . ' Sucessfully Created');
            return $this->redirectToRoute('getemail', ['id' => $thisemail->getId()]);
        }


        return $this->render('Email/create.html.twig', array('form' => $form->createView()));
    }


    /**
     * Show history of previously sent mails
     * @Route("/email/all", name="getAllemail")
     * @return                Response
     */
    public function getAllemail()
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $em = $this->getDoctrine()->getManager();
        $result = $em->getRepository(Email::class)
            ->findAll();
        if (!$result) {
            $this->addFlash('success', 'There are no sent email');
            return $this->render('Email/all.html.twig');
        } else {
            return $this->render('Email/all.html.twig', ['email' => $result]);
        }
    }


    /**
     * View previously sent mail
     * @Route("/email/{id}", name="getemail")
     * @param                 $id
     * @return                Response
     */
    public function getemail($id)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $email = $this->getDoctrine()
            ->getRepository(Email::class)
            ->findOneByID($id);


        if (!$email) {
            $this->addFlash('error', 'Sent Mail not found');
            return $this->redirectToRoute('email');
        } else {
            $createdby = $this->getDoctrine()
                ->getRepository(User::class)
                ->findOneByID($email->getCreatedBy());


            return $this->render('Email/view.html.twig', ['email' => $email, 'createdby' => $createdby]);
        }
    }

    /**
     * Delete email record
     * @Route("/email/del/{id}", name="delemail")
     * @param                 $id
     * @return                Response
     */
    public function delemail($id)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $Email = $this->getDoctrine()
            ->getRepository(Email::class)
            ->findOneByID($id);

        if (!$Email) {
            $this->addFlash('error', 'Can not find email');
            return $this->redirectToRoute('getAllemail');
        } else {
            $em = $this->getDoctrine()->getManager();
            $em->remove($Email);
            $em->flush();
            $this->addFlash('success', 'email sucessfully removed');
            return $this->redirectToRoute('getAllemail');
        }
    }
}
