<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Cases;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Form\FormData;
use App\Form\Cases\CasesForm;
use App\Form\Cases\CasesEdit;
use App\Form\Cases\CasesSearchForm;
use App\Entity\Task;
use App\Entity\User;
use App\Entity\Contact;
use App\Entity\Account;
use App\Entity\Target;
use App\Entity\Lead;
use App\Entity\Opportunities;
use App\Entity\Campaigns;

class CasesController extends AbstractController
{
    /**
     * Show index of cases and a searchbox.
     * @Route("/cases", name="cases")
     */
    public function index(Request $request)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $FormData = new FormData();
        $form = $this->createForm(casesSearchForm::class, $FormData);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $cases = $this->getDoctrine()
                ->getRepository(Cases::class)
                ->findByOpportunityName($data->Search);

            if (!$cases) {
                $this->addFlash('error', 'No cases was found, Try Searching Again');
                return $this->render('cases/index.html.twig', array('form' => $form->createView()));
            } else {
                return $this->render('cases/index.html.twig', array('form' => $form->createView(), 'cases' => $cases, 'searchfor' => $data->Search));
            }
        }

        return $this->render('cases/index.html.twig', ['form' => $form->createView()]);
    }


    /**
     * @Route("/cases/create", name="createcases")
     * Create a new record of case in the database.
     * @param           Request $request
     * @return          \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function createcases(Request $request)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        if (!$this->isGranted('ROLE_ADMIN') && !$this->isGranted('ROLE_MANAGER')) {
            $this->addFlash('error', 'You dont have permission to acccess this page');

            return $this->redirectToRoute('cases');
        }


        $FormData = new FormData();
        $form = $this->createForm(CasesForm::class, $FormData);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $CheckCases = $this->getDoctrine()
                ->getRepository(Cases::class)
                ->findOneByAccountID($data->AccountName->getId());
            $Cases = new Cases();

            if (!empty($CheckCases)) {
                $this->addFlash('error', 'This Account already has a case file');

                return $this->redirectToRoute('createcases');
            }


            if (!is_null($data->AssignedTo)) {
                $Cases->setAssignedTo($data->AssignedTo->getFirstName());
                $Cases->setAssignedToId($data->AssignedTo->getId());
            }
            $Cases->setSubject($data->Subject);
            $Cases->setDescription($data->Description);


            if (!is_null($data->AccountName)) {
                $Cases->setAccountName($data->AccountName->getName());
                $Cases->setAccountId($data->AccountName->getId());
            }
            $Cases->setPriority($data->Priority);
            $Cases->setType($data->Type);
            $Cases->setStatus($data->Status);
            $Cases->setResolution($data->Resolution);

            $Cases->setDateCreated(date('m/d/Y h:i:s a', time()));
            $Cases->setCreatedBy($this->getUser()->getId());
            $em->persist($Cases);
            $em->flush();

            $thiscases = $this->getDoctrine()
                ->getRepository(Cases::class)
                ->findOneByID($Cases->getID());

            $this->addFlash('success', 'Cases ' . $thiscases->getSubject() . ' Sucessfully Created');
            return $this->redirectToRoute('getcases', ['id' => $thiscases->getID()]);
        }


        return $this->render('cases/create.html.twig', array('form' => $form->createView()));
    }


    /**
     * Allows editing of cases by administrators and managers.
     * @Route("/cases/edit/{id}", name="editcases")
     * @param           Request $request
     * @return          \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function editcases(Request $request, $id)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $Cases = $this->getDoctrine()
            ->getRepository(Cases::class)
            ->findOneByID($id);


        if (!$Cases) {
            $this->addFlash('error', 'This cases does not exist');

            return $this->render('cases/index.html.twig');
        }

        if (!$this->isGranted('ROLE_ADMIN') && !$this->isGranted('ROLE_MANAGER') && $this->getUser()->getId() !== $Cases->getAssignedToId()) {
            $this->addFlash('error', 'You dont have permission to acccess this page');

            return $this->redirectToRoute('cases');
        }


        $form = $this->createForm(CasesEdit::class, $Cases);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $Cases->setSubject($data->getSubject());

            $Cases->setDescription($data->getDescription());
            $Cases->setStatus($data->getStatus());
            if (!is_null($form->get('AccountName')->getData())) {
                $Cases->setAccountName($form->get('AccountName')->getData()->getName());

                $Cases->setAccountId($form->get('AccountName')->getData()->getId());
            }

            if (!is_null($form->get('AssignedTo')->getData())) {
                $Cases->setAssignedTo($form->get('AssignedTo')->getData()->getName());
                $Cases->setAssignedToId($form->get('AssignedTo')->getData()->getId());
            }

            $Cases->setDateModified(date('m/d/Y h:i:s a', time()));
            $Cases->setCreatedBy($this->getUser()->getId());
            $em->persist($Cases);
            $em->flush();

            $thiscases = $this->getDoctrine()
                ->getRepository(Cases::class)
                ->findOneByID($Cases->getID());

            $this->addFlash('success', 'Cases ' . $thiscases->getSubject() . ' Sucessfully Edited');
            return $this->redirectToRoute('getcases', ['id' => $thiscases->getID()]);
        }


        return $this->render('cases/edit.html.twig', array('form' => $form->createView()));
    }


    /**
     * Get lists of all cases.
     * @Route("/cases/all", name="getAllcases")
     * @return                Response
     */
    public function getAllcases()
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $em = $this->getDoctrine()->getManager();
        $result = $em->getRepository(Cases::class)
            ->findAll();
        if (!$result) {
            $this->addFlash('success', 'There are no created cases');
            return $this->render('cases/all.html.twig');
        } else {
            return $this->render('cases/all.html.twig', ['cases' => $result]);
        }
    }


    /**
     * Fetch just one case using get response
     * @Route("/cases/{id}", name="getcases")
     * @param                 $id
     * @return                Response
     */
    public function getcases($id)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $cases = $this->getDoctrine()
            ->getRepository(Cases::class)
            ->findOneByID($id);


        if (!$cases) {
            $this->addFlash('error', 'Cases not found');
            return $this->redirectToRoute('cases');
        } else {
            $createdby = $this->getDoctrine()
                ->getRepository(User::class)
                ->findOneByID($cases->getCreatedBy());

            return $this->render('cases/view.html.twig', ['cases' => $cases, 'createdby' => $createdby]);
        }
    }

    /**
     * Delete case
     * @Route("/cases/del/{id}", name="delcases")
     * @param                 $id
     * @return                Response
     */
    public function delcases($id)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $Cases = $this->getDoctrine()
            ->getRepository(Cases::class)
            ->findOneByID($id);

        if (!$Cases) {
            $this->addFlash('error', 'Can not find cases');
            return $this->redirectToRoute('getAllcases');
        } else {
            $em = $this->getDoctrine()->getManager();
            $em->remove($Cases);
            $em->flush();
            $this->addFlash('success', 'cases sucessfully removed');
            return $this->redirectToRoute('getAllcases');
        }
    }
}
