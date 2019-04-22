<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Contact;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Form\FormData;
use App\Form\ContactForm;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
     */
    public function index(Request $request)
    {
        $form = $this->createForm(contactSearchForm::class, $FormData);
        $form->handleRequest($request);
        $FormData = new FormData();
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $query = $em->createQuery('SELECT p FROM deicrm:ei_Contact
  WHERE p.name LIKE :data')
  ->setParameter('data', $data->search);

            $res = $query->getResult();

            if (!$query) {
                $this->addFlash('success', 'No contact was found, Try Searching Again');
                return $this->render('contact/index.html.twig', array('form' => $form->createView()));
            } else {
                return $this->render('contact/search.html.twig', array('form' => $form->createView(), 'contact' => $res));
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
            $em->persist($Contact);
            $em->flush();

            $this->addFlash('success', 'Contact Sucessfully Created');

            return $this->redirectToRoute('contact');
        }


        return $this->render('contact/create.html.twig', array('form' => $form->createView()));
    }



    /**
     * @Route("/contact/edit/{username}", name="editcontact")
     * @param                 $username
     * @return                Response
     */
    public function editcontact(Request $request)
    {
        $form = $this->createForm(contactForm::class, $FormData);
        $form->handleRequest($request);
        $FormData = new FormData();
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $result = $em->getRepository('deicrm')
      ->findOneBy(['dei_user' => $data->name]);
            if (!$result) {
                $this->addFlash('success', 'This contact is Invalid');
                return $this->render('contact/index.html.twig', array('form' => $form->createView()));
            } else {
                $Contact->setEmail($data->Email);
                $Contact->setUsername($data->Username);
                $Contact->setPassword($data->Password);
                $Contact->setName($data->Name);
                $Contact->setOfficePhone($data->OfficePhone);
                $Contact->setBillingStreet($data->BillingStreet);
                $Contact->setBillingCity($data->BillingCity);
                $Contact->setBillingPostalCode($data->BillingPostalCode);
                $Contact->setBillingCountry($data->BillingCountry);
                $Contact->setShippingStreet($data->ShippingStreet);
                $Contact->setShippingCity($data->ShippingCity);
                $Contact->setShippingState($data->ShippingState);
                $Contact->setShippingPostalCode($data->ShippingPostalCode);
                $Contact->setShippingCountry($data->ShippingCountry);
                $Contact->setDescription($data->Description);
                $Contact->setType($data->Type);
                $Contact->setAnnualRevenue($data->AnnualRevenue);
                $Contact->setSICCode($data->SICCode);
                $Contact->setIndustry($data->Industry);
                $Contact->setEmployees($data->Employees);
                $Contact->setTickerSymbol($data->TickerSymbol);
                $Contact->setOwnership($data->Ownership);
                $Contact->setRating($data->Rating);
                $Contact->persist($result);
                $Contact->flush();

                $this->addFlash('success', 'contact Sucessfully Created');

                return $this->render('contact/edit.html.twig', array('form' => $form->createView()));
            }
        }
    }

    /**
     * @Route("/contact/all", name="getAllcontact")
     * @param                 $username
     * @return                Response
     */
    public function getAllcontact()
    {
        $em = $this->getDoctrine()->getManager();
        $result = $em->getRepository('deicrm:dei_user')
            ->findAll();
        if (!$result) {
            $this->addFlash('success', 'There are no created contact');
            return $this->render('contact/all.html.twig', array('form' => $form->createView()));
        } else {
            return $this->render('contact/all.html.twig', array('form' => $form->createView(), 'contact' => $result));
        }
    }




    /**
     * @Route("/contact/{username}", name="getcontact")
     * @param                 $username
     * @return                Response
     */
    public function getcontact(Request $request)
    {
        $form = $this->createForm(contactForm::class, $FormData);
        $form->handleRequest($request);
        $FormData = new FormData();
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $result = $em->getRepository('deicrm')
      ->findOneBy(['dei_user' => $data->name]);
            if (!$result) {
                $this->addFlash('success', 'This contact is Invalid');
                return $this->render('contact/index.html.twig', array('form' => $form->createView()));
            } else {
                return $this->render('contact/profile.html.twig', array('form' => $form->createView(), 'contact' => $result));
            }
        }
    }

    /**
     * @Route("/contact/del/{username}", name="delcontact")
     * @param                 $username
     * @return                Response
     */
    public function delcontact(Request $request)
    {
        $form = $this->createForm(contactForm::class, $FormData);
        $form->handleRequest($request);
        $FormData = new FormData();
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $result = $em->getRepository('deicrm')
      ->findOneBy(['dei_user' => $data->name]);
            if (!$result) {
                $this->addFlash('success', 'This contact is Invalid');
                return $this->render('contact/index.html.twig', array('form' => $form->createView()));
            } else {
                $em->remove($result);
                $em->flush();
                $this->addFlash('success', 'contact sucessfully deleted');
                return $this->render('contact/index.html.twig', array('form' => $form->createView()));
            }
        }
    }
}
