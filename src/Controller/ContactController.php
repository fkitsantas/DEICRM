<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Contact;
use App\Entity\User;
use App\Entity\Interaction;
use App\Entity\Opportunities;
use App\Entity\Task;
use App\Entity\Note;

use App\Entity\Meeting;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Form\FormData;
use App\Form\Contact\ContactForm;
use App\Form\Interaction\InteractionForm;
use App\Form\Contact\ContactEdit;
use App\Form\Contact\ContactSearchForm;

class ContactController extends AbstractController
{
    /**
     * Contact view with a searchbox.
     * @Route("/contact", name="contact")
     */
    public function index(Request $request)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $FormData = new FormData();
        $form = $this->createForm(contactSearchForm::class, $FormData);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $contact = $this->getDoctrine()
                ->getRepository(Contact::class)
                ->findByLastName($data->Search);

            if (!$contact) {
                $this->addFlash('error', 'No contact was found, Try Searching Again');
                return $this->render('contact/index.html.twig', array('form' => $form->createView()));
            } else {
                return $this->render('contact/index.html.twig', array('form' => $form->createView(), 'contact' => $contact, 'searchfor' => $data->Search));
            }
        }

        return $this->render('contact/index.html.twig', ['form' => $form->createView()]);
    }

    /**
     * Allows creating of contact.
     * @Route("/contact/create", name="createcontact")
     * @param           Request $request
     * @return          \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function createcontact(Request $request)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        if (!$this->isGranted('ROLE_ADMIN') && !$this->isGranted('ROLE_MANAGER')) {
            $this->addFlash('error', 'You dont have permission to acccess this page');

            return $this->redirectToRoute('contact');
        }
        $FormData = new FormData();
        $form = $this->createForm(ContactForm::class, $FormData);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $Contact = new Contact();
            $Contact->setEmailAddress($data->EmailAddress);
            $Contact->setFirstName($data->FirstName);
            $Contact->setLastName($data->LastName);
            $Contact->setTitle($data->Title);
            $Contact->setDepartment($data->Department);
            $Contact->setOfficePhone($data->OfficePhone);
            $Contact->setMobile($data->Mobile);
            $Contact->setFax($data->Fax);
            $Contact->setPrimaryAddressStreet($data->PrimaryAddressStreet);
            $Contact->setPrimaryAddressCity($data->PrimaryAddressCity);
            $Contact->setPrimaryAddressState($data->PrimaryAddressState);
            $Contact->setPrimaryAddressPostalCode($data->PrimaryAddressPostalCode);
            $Contact->setPrimaryAddressCountry($data->PrimaryAddressCountry);
            $Contact->setAlternateAddressStreet($data->AlternateAddressStreet);
            $Contact->setAlternateAddressCity($data->AlternateAddressCity);
            $Contact->setAlternateAddressState($data->AlternateAddressState);
            $Contact->setAlternateAddressPostalCode($data->AlternateAddressPostalCode);
            $Contact->setAlternateAddressCountry($data->AlternateAddressCountry);
            $Contact->setEmailAddress($data->EmailAddress);
            $Contact->setDescription($data->Description);
            $Contact->setLeadSource($data->LeadSource);
            if (!is_null($data->ReportsTo)) {
                $Contact->setReportsTo($data->ReportsTo->getFirstName());
                $Contact->setReportsToId($data->ReportsTo->getid());
            }
            if (!is_null($data->AssignedTo)) {
                $Contact->setAssignedTo($data->AssignedTo->getFirstName());
                $Contact->setAssignedToId($data->AssignedTo->getId());
            }
            $Contact->setDateCreated(date('m/d/Y h:i:s a', time()));
            $Contact->setCreatedBy($this->getUser()->getId());
            $em->persist($Contact);
            $em->flush();
            $thiscontact = $this->getDoctrine()
                ->getRepository(Contact::class)
                ->findOneByID($Contact->getID());
            $this->addFlash('success', 'Contact ' . $thiscontact->getFirstName() . ' Sucessfully Created');
            return $this->redirectToRoute('getcontact', ['id' => $thiscontact->getID()]);
        }
        return $this->render('contact/create.html.twig', array('form' => $form->createView()));
    }


    /**
     * Allows editing of  contact.
     * @Route("/contact/edit/{id}", name="editcontact")
     * @param           Request $request
     * @return          \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function editcontact(Request $request, $id)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $Contact = $this->getDoctrine()
            ->getRepository(Contact::class)
            ->findOneByID($id);

        if (!$Contact) {
            $this->addFlash('error', 'This contact does not exist');

            return $this->render('contact/index.html.twig');
        }

        if (!$this->isGranted('ROLE_ADMIN') && !$this->isGranted('ROLE_MANAGER') && $this->getUser()->getId() !== $Contact->getAssignedToId()) {
            $this->addFlash('error', 'You dont have permission to acccess this page');

            return $this->redirectToRoute('contact');
        }


        $form = $this->createForm(ContactEdit::class, $Contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $Contact->setEmailAddress($data->getEmailAddress());
            $Contact->setFirstName($data->getFirstName());
            $Contact->setLastName($data->getLastName());
            $Contact->setTitle($data->getTitle());
            $Contact->setDepartment($data->getDepartment());
            $Contact->setOfficePhone($data->getOfficePhone());
            $Contact->setMobile($data->getMobile());
            $Contact->setFax($data->getFax());
            $Contact->setPrimaryAddressStreet($data->getPrimaryAddressStreet());
            $Contact->setPrimaryAddressCity($data->getPrimaryAddressCity());
            $Contact->setPrimaryAddressState($data->getPrimaryAddressState());
            $Contact->setPrimaryAddressPostalCode($data->getPrimaryAddressPostalCode());
            $Contact->setPrimaryAddressCountry($data->getPrimaryAddressCountry());
            $Contact->setAlternateAddressStreet($data->getAlternateAddressStreet());
            $Contact->setAlternateAddressCity($data->getAlternateAddressCity());
            $Contact->setAlternateAddressState($data->getAlternateAddressState());
            $Contact->setAlternateAddressPostalCode($data->getAlternateAddressPostalCode());
            $Contact->setAlternateAddressCountry($data->getAlternateAddressCountry());
            $Contact->setEmailAddress($data->getEmailAddress());
            $Contact->setDescription($data->getDescription());
            $Contact->setReportsTo($data->getReportsTo());
            $Contact->setLeadSource($data->getLeadSource());
            if (!is_null($form->get('AssignedTo')->getData())) {
                $Contact->setAssignedTo($form->get('AssignedTo')->getData()->getFirstName());
                $Contact->setAssignedToId($form->get('AssignedTo')->getData()->getId());
            }
            $Contact->setCampaign($data->getCampaign());
            $Contact->setDateModified(date('m/d/Y h:i:s a', time()));
            $em->persist($Contact);
            $em->flush();


            $thiscontact = $this->getDoctrine()
                ->getRepository(Contact::class)
                ->findOneByID($Contact->getID());

            $this->addFlash('success', 'Contact ' . $thiscontact->getLastName() . ' Sucessfully Edited');
            return $this->redirectToRoute('getcontact', ['id' => $thiscontact->getID()]);
        }


        return $this->render('contact/edit.html.twig', array('form' => $form->createView()));
    }


    /**
     * Fetch lists of contacts.
     * @Route("/contact/all", name="getAllcontact")
     * @return                Response
     */
    public function getAllcontact()
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $em = $this->getDoctrine()->getManager();
        $result = $em->getRepository(Contact::class)
            ->findAll();
        if (!$result) {
            $this->addFlash('success', 'There are no created contact');
            return $this->render('contact/all.html.twig');
        } else {
            return $this->render('Contact/all.html.twig', ['contact' => $result]);
        }
    }


    /**
     * Fetch just one record of contact from the contact table.
     * @Route("/contact/{id}", name="getcontact")
     * @param                 $id
     * @return                Response
     */
    public function getcontact($id)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $contact = $this->getDoctrine()
            ->getRepository(Contact::class)
            ->findOneByID($id);


        if (!$contact) {
            $this->addFlash('error', 'Contact not found');
            return $this->redirectToRoute('contact');
        } else {
            $oprepository = $this->getDoctrine()->getRepository(Opportunities::class);
            $opportunities = $oprepository->findBy(
                ['ContactId' => $id]
            );

            $taskrepository = $this->getDoctrine()->getRepository(Task::class);
            $task = $taskrepository->findBy(
                ['RelatedToType' => 'Contact',
                    'RelatedToId' => $id,
                ]
            );

            $noterepository = $this->getDoctrine()->getRepository(Note::class);
            $note = $noterepository->findBy(
                ['RelatedToType' => 'Contact',
                    'RelatedToId' => $id,
                ]
            );


            $meetingrepository = $this->getDoctrine()->getRepository(Meeting::class);
            $meeting = $meetingrepository->findBy(
                ['RelatedToType' => 'Contact',
                    'RelatedToId' => $id,
                ]
            );

            $FormData = new FormData();
            $form = $this->createForm(InteractionForm::class, $FormData, array(
                'id' => $contact->getId(), 'whoby' => $this->getUser()->getFirstName(), 'type' => 'contact'));

            $createdby = $this->getDoctrine()
                ->getRepository(User::class)
                ->findOneByID($contact->getCreatedBy());

            $repository = $this->getDoctrine()->getRepository(Interaction::class);
            $interaction = $repository->findBy(
                ['WhoTo' => $contact->getId()]
            );


            return $this->render('Contact/view.html.twig', ['contact' => $contact, 'note' => $note, 'createdby' => $createdby, 'meeting' => $meeting, 'interaction' => $interaction, 'task' => $task, 'opportunities' => $opportunities, 'form' => $form->createView()]);
        }
    }

    /**
     * Delete contact.
     * @Route("/contact/del/{id}", name="delcontact")
     * @param                 $id
     * @return                Response
     */
    public function delcontact($id)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $Contact = $this->getDoctrine()
            ->getRepository(Contact::class)
            ->findOneByID($id);

        if (!$Contact) {
            $this->addFlash('error', 'Can not find contact');
            return $this->redirectToRoute('getAllcontact');
        } else {
            $em = $this->getDoctrine()->getManager();
            $em->remove($Contact);
            $em->flush();
            $this->addFlash('success', 'contact sucessfully removed');
            return $this->redirectToRoute('getAllcontact');
        }
    }
}
