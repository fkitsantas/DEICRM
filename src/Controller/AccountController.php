<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Account;
use App\Entity\User;
use App\Entity\Contact;
use App\Entity\Task;
use App\Entity\Cases;
use App\Entity\Note;
use App\Entity\Meeting;
use App\Entity\CasesComment;
use App\Entity\Opportunities;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Form\FormData;
use App\Form\Account\AccountForm;
use App\Form\Account\AccountEdit;
use App\Form\Account\AccountSearchForm;
use App\Form\Cases\CasesCommentForm;
use App\Service\RolesToText;

class AccountController extends AbstractController
{
    /**
     * Show index page with a search bar to search account.
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

        return $this->render('account/index.html.twig', ['form' => $form->createView()]);
    }

    /**
     * Handles storing of account to the database.
     * @Route("/account/create", name="createaccount")
     * @param           Request $request
     * @return          \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function createaccount(Request $request)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        if (!$this->isGranted('ROLE_ADMIN') && !$this->isGranted('ROLE_MANAGER')) {
            $this->addFlash('error', 'You dont have permission to acccess this page');

            return $this->redirectToRoute('account');
        }

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
            if (!is_null($data->MemberOf)) {
                $Account->setMemberOf($data->MemberOf->getName());
                $Account->setMemberOfId($data->MemberOf->getId());
            }
            $Account->setIndustry($data->Industry);
            $Account->setEmployees($data->Employees);
            $Account->setTickerSymbol($data->TickerSymbol);
            $Account->setOwnership($data->Ownership);
            $Account->setRating($data->Rating);
            if (!is_null($data->Campaign)) {
                $Account->setCampaign($data->Campaign->getName());
                $Account->setCampaignId($data->Campaign->getId());
            }
            if (!is_null($data->AssignedTo)) {
                $Account->setAssignedTo($data->AssignedTo->getFirstName());

                $Account->setAssignedToId($data->AssignedTo->getId());
            }
            $Account->setDateCreated(date('m/d/Y h:i:s a', time()));
            $Account->setCreatedBy($this->getUser()->getId());
            $em->persist($Account);
            $em->flush();


            $thisaccount = $this->getDoctrine()
                ->getRepository(Account::class)
                ->findOneByID($Account->getID());

            $this->addFlash('success', 'Account ' . $thisaccount->getName() . ' Sucessfully Created');
            return $this->redirectToRoute('getaccount', ['id' => $thisaccount->getID()]);
        }


        return $this->render('account/create.html.twig', array('form' => $form->createView()));
    }


    /**
     * @Route("/account/edit/{id}", name="editaccount")
     * Allow editing of account details  by administrator and manager.
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

        if (!$this->isGranted('ROLE_ADMIN') && !$this->isGranted('ROLE_MANAGER') && $this->getUser()->getId() !== $Account->getAssignedToId()) {
            $this->addFlash('error', 'You dont have permission to acccess this page');

            return $this->redirectToRoute('account');
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
            if (!is_null($form->get('AssignedTo')->getData())) {
                $Account->setAssignedTo($form->get('AssignedTo')->getData()->getFirstName());
                $Account->setAssignedToId($form->get('AssignedTo')->getData()->getId());
            }
            $Account->setDateModified(date('m/d/Y h:i:s a', time()));
            $em->persist($Account);
            $em->flush();


            $thisaccount = $this->getDoctrine()
                ->getRepository(Account::class)
                ->findOneByID($Account->getID());

            $this->addFlash('success', 'Account ' . $thisaccount->getName() . ' Sucessfully Edited');
            return $this->redirectToRoute('getaccount', ['id' => $thisaccount->getID()]);
        }


        return $this->render('account/edit.html.twig', array('form' => $form->createView()));
    }


    /**
     * Fetch all account details from the account table in the database.
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
     * Fetch account details from the database.
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
            $oprepository = $this->getDoctrine()->getRepository(Opportunities::class);
            $opportunities = $oprepository->findBy(
                ['AccountId' => $id]
            );

            $taskrepository = $this->getDoctrine()->getRepository(Task::class);
            $task = $taskrepository->findBy(
                ['RelatedToType' => 'Account',
                    'RelatedToId' => $id,
                ]
            );


            $noterepository = $this->getDoctrine()->getRepository(Note::class);
            $note = $noterepository->findBy(
                ['RelatedToType' => 'Account',
                    'RelatedToId' => $id,
                ]
            );


            $meetingrepository = $this->getDoctrine()->getRepository(Meeting::class);
            $meeting = $meetingrepository->findBy(
                ['RelatedToType' => 'Account',
                    'RelatedToId' => $id,
                ]
            );


            $casesrepository = $this->getDoctrine()->getRepository(Cases::class);
            $cases = $casesrepository->findOneBy(
                ['AccountId' => $id,
                ]
            );

            $createdby = $this->getDoctrine()
                ->getRepository(User::class)
                ->findOneByID($account->getCreatedBy());

            if (is_null($account->getName())) {
                $accountid = $account->getId();
                $accountname = $account->getName();
            } else {
                $accountid = $account->getId();
                $accountname = $account->getName();
            }
            $FormData = new FormData();
            if ($cases) {
                $form = $this->createForm(CasesCommentForm::class, $FormData, array(
                    'caseid' => $cases->getId(), 'addedbyid' => $this->getUser()->getId(), 'addedby' => $this->getUser()->getFirstName(), 'accountname' => $accountname, 'accountid' => $accountid));

                $casescomment = $this->getDoctrine()->getManager()->getRepository(CasesComment::class)->findBy(
                    array('CaseId' => $cases->getId()),
                    array('id' => 'ASC')
                );

                return $this->render('account/view.html.twig', ['account' => $account, 'opportunities' => $opportunities, 'task' => $task, 'note' => $note, 'createdby' => $createdby, 'meeting' => $meeting, 'cases' => $cases, 'casescomment' => $casescomment, 'form' => $form->createView()]);
            } else {
                return $this->render('account/view.html.twig', ['account' => $account, 'opportunities' => $opportunities, 'task' => $task, 'note' => $note, 'createdby' => $createdby, 'meeting' => $meeting, 'cases' => '', 'casescomment' => '']);
            }
        }
    }

    /**
     * Delete account from the database
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
