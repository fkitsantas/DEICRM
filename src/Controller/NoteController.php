<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Note;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Form\FormData;
use App\Form\Note\NoteForm;
use App\Form\Note\NoteEdit;
use App\Form\Note\NoteSearchForm;
use App\Entity\Task;
use App\Entity\User;
use App\Entity\Contact;
use App\Entity\Account;
use App\Entity\Target;
use App\Entity\Lead;
use App\Entity\Opportunities;
use App\Entity\Campaigns;

class NoteController extends AbstractController
{
    /**
     * View for Notes and a searchbox for searching notes from notes table.
     * @Route("/note", name="note")
     */
    public function index(Request $request)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $FormData = new FormData();
        $form = $this->createForm(noteSearchForm::class, $FormData);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $note = $this->getDoctrine()
                ->getRepository(Note::class)
                ->findByOpportunityName($data->Search);

            if (!$note) {
                $this->addFlash('error', 'No note was found, Try Searching Again');
                return $this->render('note/index.html.twig', array('form' => $form->createView()));
            } else {
                return $this->render('note/index.html.twig', array('form' => $form->createView(), 'note' => $note, 'searchfor' => $data->Search));
            }
        }

        return $this->render('note/index.html.twig', ['form' => $form->createView()]);
    }


    /**
     * Create a new instance of note in the database.
     * @Route("/note/create", name="createnote")
     * @param           Request $request
     * @return          \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function createnote(Request $request)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        if (!$this->isGranted('ROLE_ADMIN') && !$this->isGranted('ROLE_MANAGER')) {
            $this->addFlash('error', 'You dont have permission to acccess this page');

            return $this->redirectToRoute('note');
        }


        $tasks = $this->getDoctrine()->getRepository(Task::class)->findAll();
        $note = $this->getDoctrine()->getRepository(Note::class)->findAll();
        $contact = $this->getDoctrine()->getRepository(Contact::class)->findAll();
        $leads = $this->getDoctrine()->getRepository(Lead::class)->findAll();
        $account = $this->getDoctrine()->getRepository(Account::class)->findAll();
        $target = $this->getDoctrine()->getRepository(Target::class)->findAll();
        $campaign = $this->getDoctrine()->getRepository(Campaigns::class)->findAll();
        $opportunities = $this->getDoctrine()->getRepository(Opportunities::class)->findAll();


        $FormData = new FormData();
        $form = $this->createForm(NoteForm::class, $FormData);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $Note = new Note();
            $Note->setSubject($data->Subject);

            $Note->setNote($data->Note);

            if (!is_null($data->AssignedTo)) {
                $Note->setAssignedTo($data->AssignedTo->getFirstName());
                $Note->setAssignedToId($data->AssignedTo->getId());
            }
            if (!is_null($data->ContactName)) {
                $Note->setContactName($data->ContactName->getFirstName());
            }

            if (!is_null($request->request->get('RelatedTo'))) {
                $RelatedToId = $request->request->get('RelatedTo');
                $RelatedToType = $request->request->get('RelatedToType');
                $RelatedToValue = $request->request->get('RelatedToValue');

                $Note->setRelatedToId($RelatedToId);
                $Note->setRelatedToType($RelatedToType);
                $Note->setRelatedTo($RelatedToValue);
            }

            $Note->setDateCreated(date('m/d/Y h:i:s a', time()));
            $Note->setCreatedBy($this->getUser()->getId());
            $em->persist($Note);
            $em->flush();

            $thisnote = $this->getDoctrine()
                ->getRepository(Note::class)
                ->findOneByID($Note->getID());

            $this->addFlash('success', 'Note ' . $thisnote->getSubject() . ' Sucessfully Created');
            return $this->redirectToRoute('getnote', ['id' => $thisnote->getID()]);
        }


        return $this->render('Note/create.html.twig', array('form' => $form->createView(), 'tasks' => $tasks, 'leads' => $leads, 'note' => $note, 'contact' => $contact, 'target' => $target, 'opportunities' => $opportunities, 'campaigns' => $campaign, 'account' => $account));
    }


    /**
     * Edit an instance of note.
     * @Route("/note/edit/{id}", name="editnote")
     * @param           Request $request
     * @return          \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function editnote(Request $request, $id)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $Note = $this->getDoctrine()
            ->getRepository(Note::class)
            ->findOneByID($id);


        if (!$Note) {
            $this->addFlash('error', 'This note does not exist');

            return $this->render('note/index.html.twig');
        }

        if (!$this->isGranted('ROLE_ADMIN') && !$this->isGranted('ROLE_MANAGER') && $this->getUser()->getId() !== $Note->getAssignedToId()) {
            $this->addFlash('error', 'You dont have permission to acccess this page');

            return $this->redirectToRoute('note');
        }


        $form = $this->createForm(NoteEdit::class, $Note);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $Note->setSubject($data->getSubject());

            $Note->setNote($data->getNote());
            if (!is_null($form->get('ContactName')->getData())) {
                $Note->setContactName($form->get('ContactName')->getData()->getFirstName());
            }

            if (!is_null($form->get('AssignedTo')->getData())) {
                $Note->setAssignedTo($form->get('AssignedTo')->getData()->getFirstName());
                $Note->setAssignedToId($form->get('AssignedTo')->getData()->getId());
            }
            //$Note->setRelatedToType($data->getRelatedToType());
            //$Note->setRelatedTo($data->getRelatedTo());

            $Note->setDateModified(date('m/d/Y h:i:s a', time()));
            $Note->setCreatedBy($this->getUser()->getId());
            $em->persist($Note);
            $em->flush();

            $thisnote = $this->getDoctrine()
                ->getRepository(Note::class)
                ->findOneByID($Note->getID());

            $this->addFlash('success', 'Note ' . $thisnote->getSubject() . ' Sucessfully Edited');
            return $this->redirectToRoute('getnote', ['id' => $thisnote->getID()]);
        }


        return $this->render('Note/edit.html.twig', array('form' => $form->createView()));
    }


    /**
     * Fetch notes
     * @Route("/note/all", name="getAllnote")
     * @return                Response
     */
    public function getAllnote()
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $em = $this->getDoctrine()->getManager();
        $result = $em->getRepository(Note::class)
            ->findAll();
        if (!$result) {
            $this->addFlash('success', 'There are no created note');
            return $this->render('Note/all.html.twig');
        } else {
            return $this->render('Note/all.html.twig', ['note' => $result]);
        }
    }


    /**
     * Get an instance of note.
     * @Route("/note/{id}", name="getnote")
     * @param                 $id
     * @return                Response
     */
    public function getnote($id)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $note = $this->getDoctrine()
            ->getRepository(Note::class)
            ->findOneByID($id);


        if (!$note) {
            $this->addFlash('error', 'Note not found');
            return $this->redirectToRoute('note');
        } else {
            $createdby = $this->getDoctrine()
                ->getRepository(User::class)
                ->findOneByID($note->getCreatedBy());

            return $this->render('Note/view.html.twig', ['note' => $note, 'createdby' => $createdby]);
        }
    }

    /**
     * Delete an instance of note.
     * @Route("/note/del/{id}", name="delnote")
     * @param                 $id
     * @return                Response
     */
    public function delnote($id)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $Note = $this->getDoctrine()
            ->getRepository(Note::class)
            ->findOneByID($id);

        if (!$Note) {
            $this->addFlash('error', 'Can not find note');
            return $this->redirectToRoute('getAllnote');
        } else {
            $em = $this->getDoctrine()->getManager();
            $em->remove($Note);
            $em->flush();
            $this->addFlash('success', 'note sucessfully removed');
            return $this->redirectToRoute('getAllnote');
        }
    }
}
