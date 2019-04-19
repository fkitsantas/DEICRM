<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Seo\AuditBundle\Entity\User;

class ContactController extends AbstractController
{
    /**
     * @Route("/contacts", name="contact")
     */
    public function index()
    {
        return $this->render('contact/index.html.twig', [
            'controller_name' => 'contactController',
        ]);
    }

    /**
     * @Route("/contact/create", name="createcontact")
     * @param           Request $request
     * @return          \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function createcontact(Request $request)
    {
        $form = $this->createForm(contactForm::class, $FormData);
        $form->handleRequest($request);
        $FormData = new FormData();
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $User = new User();
            $User->setEmail($data->Email);
            $User->setUsername($data->Username);
            $User->setPassword($data->Password);
            $User->setName($data->Name);
            $User->setOfficePhone($data->OfficePhone);
            $User->setBillingStreet($data->BillingStreet);
            $User->setBillingCity($data->BillingCity);
            $User->setBillingPostalCode($data->BillingPostalCode);
            $User->setBillingCountry($data->BillingCountry);
            $User->setShippingStreet($data->ShippingStreet);
            $User->setShippingCity($data->ShippingCity);
            $User->setShippingState($data->ShippingState);
            $User->setShippingPostalCode($data->ShippingPostalCode);
            $User->setShippingCountry($data->ShippingCountry);
            $User->setDescription($data->Description);
            $User->setType($data->Type);
            $User->setAnnualRevenue($data->AnnualRevenue);
            $User->setSICCode($data->SICCode);
            $User->setIndustry($data->Industry);
            $User->setEmployees($data->Employees);
            $User->setTickerSymbol($data->TickerSymbol);
            $User->setOwnership($data->Ownership);
            $User->setRating($data->Rating);
            $User->persist($result);
            $User->flush();

            $this->addFlash('success', 'contact Sucessfully Created');

            return $this->render('contact/create.html.twig', array('form' => $form->createView()));
        }
    }



    /**
     * @Route("/contact/search/{username}", name="searchcontact")
     * @param                 $username
     * @return                Response
     */
    public function searchcontact(Request $request)
    {
        $form = $this->createForm(contactForm::class, $FormData);
        $form->handleRequest($request);
        $FormData = new FormData();
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $query = $em->createQuery('SELECT p FROM deicrm:ei_user p
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
                $User->setEmail($data->Email);
                $User->setUsername($data->Username);
                $User->setPassword($data->Password);
                $User->setName($data->Name);
                $User->setOfficePhone($data->OfficePhone);
                $User->setBillingStreet($data->BillingStreet);
                $User->setBillingCity($data->BillingCity);
                $User->setBillingPostalCode($data->BillingPostalCode);
                $User->setBillingCountry($data->BillingCountry);
                $User->setShippingStreet($data->ShippingStreet);
                $User->setShippingCity($data->ShippingCity);
                $User->setShippingState($data->ShippingState);
                $User->setShippingPostalCode($data->ShippingPostalCode);
                $User->setShippingCountry($data->ShippingCountry);
                $User->setDescription($data->Description);
                $User->setType($data->Type);
                $User->setAnnualRevenue($data->AnnualRevenue);
                $User->setSICCode($data->SICCode);
                $User->setIndustry($data->Industry);
                $User->setEmployees($data->Employees);
                $User->setTickerSymbol($data->TickerSymbol);
                $User->setOwnership($data->Ownership);
                $User->setRating($data->Rating);
                $User->persist($result);
                $User->flush();

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
