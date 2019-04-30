<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Account;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Form\FormData;
use App\Form\Account\AccountForm;
use App\Form\Account\AccountEdit;
use App\Form\Account\AccountSearchForm;

class AccountController extends AbstractController
{
    /**
     * @Route("/account", name="account")
     */
    public function index(Request $request)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $FormData = new FormData();
        $form = $this->createForm(accountSearchForm::class, $FormData);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $account = $this->getDoctrine()
    ->getRepository(Account::class)
    ->findByName($data->Search);

            if (!$account) {
                $this->addFlash('error', 'No account was found, Try Searching Again');
                return $this->render('account/index.html.twig', array('form' => $form->createView()));
            } else {
                return $this->render('account/index.html.twig', array('form' => $form->createView(), 'account' => $account, 'searchfor' => $data->Search));
            }
        }

        return $this->render('account/index.html.twig', [ 'form' => $form->createView()]);
    }

    /**
     * @Route("/account/create", name="createaccount")
     * @param           Request $request
     * @return          \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function createaccount(Request $request)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $FormData = new FormData();
        $form = $this->createForm(AccountForm::class, $FormData);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $Account = new Account();
            $Account->setEmailAddress($data->EmailAddress);
            $Account->setName($data->Name);
            $Account->setWebsite($data->Website);
            $Account->setOfficePhone($data->OfficePhone);
            $Account->setFax($data->Fax);
            $Account->setBillingAddressStreet($data->BillingAddressStreet);
            $Account->setBillingAddressCity($data->BillingAddressCity);
            $Account->setBillingAddressState($data->BillingAddressState);
            $Account->setBillingAddressPostalCode($data->BillingAddressPostalCode);
            $Account->setBillingAddressCountry($data->BillingAddressCountry);
            $Account->setShippingAddressStreet($data->ShippingAddressStreet);
            $Account->setShippingAddressCity($data->ShippingAddressCity);
            $Account->setShippingAddressState($data->ShippingAddressState);
            $Account->setShippingAddressPostalCode($data->ShippingAddressPostalCode);
            $Account->setType($data->Type);
            $Account->setAnnualRevenue($data->AnnualRevenue);
            $Account->setSICCode($data->SICCode);
            $Account->setMemberOf($data->MemberOf->getName());
            $Account->setMemberOfId($data->MemberOf->getId());
            $Account->setIndustry($data->Industry);
            $Account->setEmployees($data->Employees);
            $Account->setTickerSymbol($data->TickerSymbol);
            $Account->setOwnership($data->Ownership);
            $Account->setRating($data->Rating);
            $Account->setCampaign($data->Campaign->getName());
            $Account->setCampaignId($data->Campaign->getId());
            $Account->setAssignedTo($data->AssignedTo->getUsername());
            $Account->setAssignedToId($data->AssignedTo->getId());
            $Account->setDateCreated(date('m/d/Y h:i:s a', time()));
            $Account->setCreatedBy($this->getUser()->getId());
            $em->persist($Account);
            $em->flush();


            $thisaccount = $this->getDoctrine()
          ->getRepository(Account::class)
          ->findOneByID($Account->getID());

            $this->addFlash('success', 'Account '.$thisaccount->getName().' Sucessfully Created');
            return $this->redirectToRoute('getaccount', ['id' => $thisaccount->getID()]);
        }


        return $this->render('account/create.html.twig', array('form' => $form->createView()));
    }




    /**
     * @Route("/account/edit/{id}", name="editaccount")
     * @param           Request $request
     * @return          \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function editaccount(Request $request, $id)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $Account = $this->getDoctrine()
      ->getRepository(Account::class)
      ->findOneByID($id);



        if (!$Account) {
            $this->addFlash('error', 'This account does not exist');

            return $this->render('account/index.html.twig');
        }


        $form = $this->createForm(AccountEdit::class, $Account);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $Account->setEmailAddress($data->getEmailAddress());
            $Account->setName($data->getName());
            $Account->setWebsite($data->getWebsite());
            $Account->setOfficePhone($data->getOfficePhone());
            $Account->setFax($data->getFax());
            $Account->setBillingAddressStreet($data->getBillingAddressStreet());
            $Account->setBillingAddressCity($data->getBillingAddressCity());
            $Account->setBillingAddressState($data->getBillingAddressState());
            $Account->setBillingAddressPostalCode($data->getBillingAddressPostalCode());
            $Account->setBillingAddressCountry($data->getBillingAddressCountry());
            $Account->setShippingAddressStreet($data->getShippingAddressStreet());
            $Account->setShippingAddressCity($data->getShippingAddressCity());
            $Account->setShippingAddressState($data->getShippingAddressState());
            $Account->setShippingAddressPostalCode($data->getShippingAddressPostalCode());
            $Account->setType($data->getType());
            $Account->setAnnualRevenue($data->getAnnualRevenue());
            $Account->setSICCode($data->getSICCode());
            $Account->setIndustry($data->getIndustry());
            $Account->setEmployees($data->getEmployees());
            $Account->setTickerSymbol($data->getTickerSymbol());
            $Account->setOwnership($data->getOwnership());
            $Account->setRating($data->getRating());
            $Account->setDateModified(date('m/d/Y h:i:s a', time()));
            $em->persist($Account);
            $em->flush();


            $thisaccount = $this->getDoctrine()
          ->getRepository(Account::class)
          ->findOneByID($Account->getID());

            $this->addFlash('success', 'Account '.$thisaccount->getName().' Sucessfully Edited');
            return $this->redirectToRoute('getaccount', ['id' => $thisaccount->getID()]);
        }


        return $this->render('account/edit.html.twig', array('form' => $form->createView()));
    }




    /**
     * @Route("/account/all", name="getAllaccount")
     * @return                Response
     */
    public function getAllaccount()
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $em = $this->getDoctrine()->getManager();
        $result = $em->getRepository(Account::class)
            ->findAll();
        if (!$result) {
            $this->addFlash('success', 'There are no created account');
            return $this->render('account/all.html.twig');
        } else {
            return $this->render('account/all.html.twig', ['account' => $result]);
        }
    }




    /**
     * @Route("/account/{id}", name="getaccount")
     * @param                 $id
     * @return                Response
     */
    public function getaccount($id)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $account = $this->getDoctrine()
        ->getRepository(Account::class)
        ->findOneByID($id);


        if (!$account) {
            $this->addFlash('error', 'Account not found');
            return $this->redirectToRoute('account');
        } else {
            $createdby = $this->getDoctrine()
          ->getRepository(User::class)
          ->findOneByID($account->getCreatedBy());



            return $this->render('account/view.html.twig', ['account' => $account, 'createdby' => $createdby]);
        }
    }

    /**
     * @Route("/account/del/{id}", name="delaccount")
     * @param                 $id
     * @return                Response
     */
    public function delaccount($id)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $Account = $this->getDoctrine()
    ->getRepository(Account::class)
    ->findOneByID($id);

        if (!$Account) {
            $this->addFlash('error', 'Can not find account');
            return $this->redirectToRoute('getAllaccount');
        } else {
            $em = $this->getDoctrine()->getManager();
            $em->remove($Account);
            $em->flush();
            $this->addFlash('success', 'account sucessfully removed');
            return $this->redirectToRoute('getAllaccount');
        }
    }
}
