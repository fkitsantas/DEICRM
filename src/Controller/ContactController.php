<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Contact;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Form\FormData;
use App\Form\Contact\ContactForm;
use App\Form\Contact\ContactEdit;
use App\Form\Contact\ContactSearchForm;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
     */
    public function index(Request $request)
    {
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

        return $this->render('contact/index.html.twig', [ 'form' => $form->createView()]);
    }

    /**
     * @Route("/contact/create", name="createcontact")
     * @param           Request $request
     * @return          \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function createcontact(Request $request)
    {
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
            $Contact->setReportsTo($data->ReportsTo);
            $Contact->setLeadSource($data->LeadSource);
            $Contact->setCampaign($data->Campaign);
            $Contact->setAssignedTo($data->AssignedTo);
            $Contact->setDateCreated(date('m/d/Y h:i:s a', time()));

            $Contact->setCreatedBy($this->getUser()->getId());
            $em->persist($Contact);
            $em->flush();


            $thiscontact = $this->getDoctrine()
          ->getRepository(Contact::class)
          ->findOneByID($Contact->getID());

            $this->addFlash('success', 'Contact '.$thistarget->getLastName().' Sucessfully Created');
            return $this->redirectToRoute('getcontact', ['id' => $thiscontact->getID()]);
        }


        return $this->render('contact/create.html.twig', array('form' => $form->createView()));
    }




    /**
     * @Route("/contact/edit/{id}", name="editcontact")
     * @param           Request $request
     * @return          \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function editcontact(Request $request, $id)
    {
        $Contact = $this->getDoctrine()
      ->getRepository(Contact::class)
      ->findOneByID($id);



        if (!$Contact) {
            $this->addFlash('error', 'This contact does not exist');

            return $this->render('contact/index.html.twig');
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
            $Contact->setCampaign($data->getCampaign());
            $Contact->setAssignedTo($data->getAssignedTo());
            $Contact->setDateModified(date('m/d/Y h:i:s a', time()));
            $em->persist($Contact);
            $em->flush();


            $thiscontact = $this->getDoctrine()
          ->getRepository(Contact::class)
          ->findOneByID($Contact->getID());

            $this->addFlash('success', 'Contact '.$thistarget->getLastName().' Sucessfully Edited');
            return $this->redirectToRoute('getcontact', ['id' => $thiscontact->getID()]);
        }


        return $this->render('contact/edit.html.twig', array('form' => $form->createView()));
    }




    /**
     * @Route("/contact/all", name="getAllcontact")
     * @return                Response
     */
    public function getAllcontact()
    {
        $em = $this->getDoctrine()->getManager();
        $result = $em->getRepository(Contact::class)
            ->findAll();
        if (!$result) {
            $this->addFlash('success', 'There are no created contact');
            return $this->render('contact/all.html.twig');
        } else {
            return $this->render('contact/all.html.twig', ['contact' => $result]);
        }
    }




    /**
     * @Route("/contact/{id}", name="getcontact")
     * @param                 $id
     * @return                Response
     */
    public function getcontact($id)
    {
        $contact = $this->getDoctrine()
        ->getRepository(Contact::class)
        ->findOneByID($id);


        if (!$contact) {
            $this->addFlash('error', 'Contact not found');
            return $this->redirectToRoute('contact');
        } else {
            $createdby = $this->getDoctrine()
          ->getRepository(User::class)
          ->findOneByID($contact->getCreatedBy());

            return $this->render('contact/view.html.twig', ['contact' => $contact, 'createdby' => $createdby]);
        }
    }

    /**
     * @Route("/contact/del/{id}", name="delcontact")
     * @param                 $id
     * @return                Response
     */
    public function delcontact($id)
    {
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
