<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Target;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Form\FormData;
use App\Entity\Task;
use App\Entity\Note;
use App\Entity\Meeting;
use App\Form\Target\TargetForm;
use App\Form\Target\TargetEdit;
use App\Form\Target\TargetSearchForm;

class TargetController extends AbstractController
{
    /**
     * View for target with a searchbox to search on targets from  target table.
     * @Route("/target", name="target")
     */
    public function index(Request $request)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');


        $FormData = new FormData();
        $form = $this->createForm(targetSearchForm::class, $FormData);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $target = $this->getDoctrine()
                ->getRepository(Target::class)
                ->findByLastName($data->Search);

            if (!$target) {
                $this->addFlash('error', 'No target was found, Try Searching Again');
                return $this->render('target/index.html.twig', array('form' => $form->createView()));
            } else {
                return $this->render('target/index.html.twig', array('form' => $form->createView(), 'target' => $target, 'searchfor' => $data->Search));
            }
        }

        return $this->render('target/index.html.twig', ['form' => $form->createView()]);
    }

    /**
     * Create a new instance of target.
     * @Route("/target/create", name="createtarget")
     * @param           Request $request
     * @return          \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function createtarget(Request $request)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        if (!$this->isGranted('ROLE_ADMIN') && !$this->isGranted('ROLE_MANAGER')) {
            $this->addFlash('error', 'You dont have permission to acccess this page');

            return $this->redirectToRoute('target');
        }

        $FormData = new FormData();
        $form = $this->createForm(TargetForm::class, $FormData);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $Target = new Target();
            $Target->setEmailAddress($data->EmailAddress);
            $Target->setFirstName($data->FirstName);
            $Target->setLastName($data->LastName);
            $Target->setTitle($data->Title);
            $Target->setDepartment($data->Department);
            $Target->setOfficePhone($data->OfficePhone);
            $Target->setMobile($data->Mobile);
            $Target->setFax($data->Fax);
            $Target->setPrimaryAddressStreet($data->PrimaryAddressStreet);
            $Target->setPrimaryAddressCity($data->PrimaryAddressCity);
            $Target->setPrimaryAddressState($data->PrimaryAddressState);
            $Target->setPrimaryAddressPostalCode($data->PrimaryAddressPostalCode);
            $Target->setPrimaryAddressCountry($data->PrimaryAddressCountry);
            $Target->setAlternateAddressStreet($data->AlternateAddressStreet);
            $Target->setAlternateAddressCity($data->AlternateAddressCity);
            $Target->setAlternateAddressState($data->AlternateAddressState);
            $Target->setAlternateAddressPostalCode($data->AlternateAddressPostalCode);
            $Target->setAlternateAddressCountry($data->AlternateAddressCountry);
            $Target->setEmailAddress($data->EmailAddress);
            $Target->setDescription($data->Description);
            if (!is_null($data->AssignedTo)) {
                $Target->setAssignedTo($data->AssignedTo->getFirstName());
                $Target->setAssignedToId($data->AssignedTo->getId());
            }
            $Target->setDateCreated(date('m/d/Y h:i:s a', time()));

            $Target->setCreatedBy($this->getUser()->getId());
            $em->persist($Target);
            $em->flush();


            $thistarget = $this->getDoctrine()
                ->getRepository(Target::class)
                ->findOneByID($Target->getID());

            $this->addFlash('success', 'Target ' . $thistarget->getID() . ' Sucessfully Created');

            return $this->redirectToRoute('gettarget', ['id' => $thistarget->getID()]);
        }


        return $this->render('target/create.html.twig', array('form' => $form->createView()));
    }


    /**
     * Edit instance of target.
     * @Route("/target/edit/{id}", name="edittarget")
     * @param           Request $request
     * @return          \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function edittarget(Request $request, $id)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $Target = $this->getDoctrine()
            ->getRepository(Target::class)
            ->findOneByID($id);


        if (!$Target) {
            $this->addFlash('error', 'This target does not exist');

            return $this->render('target/index.html.twig');
        }

        if (!$this->isGranted('ROLE_ADMIN') && !$this->isGranted('ROLE_MANAGER') && $this->getUser()->getId() !== $Target->getAssignedToId()) {
            $this->addFlash('error', 'You dont have permission to acccess this page');

            return $this->redirectToRoute('target');
        }


        $form = $this->createForm(TargetEdit::class, $Target);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $Target->setEmailAddress($data->getEmailAddress());
            $Target->setFirstName($data->getFirstName());
            $Target->setLastName($data->getLastName());
            $Target->setTitle($data->getTitle());
            $Target->setDepartment($data->getDepartment());
            $Target->setOfficePhone($data->getOfficePhone());
            $Target->setMobile($data->getMobile());
            $Target->setFax($data->getFax());
            $Target->setPrimaryAddressStreet($data->getPrimaryAddressStreet());
            $Target->setPrimaryAddressCity($data->getPrimaryAddressCity());
            $Target->setPrimaryAddressState($data->getPrimaryAddressState());
            $Target->setPrimaryAddressPostalCode($data->getPrimaryAddressPostalCode());
            $Target->setPrimaryAddressCountry($data->getPrimaryAddressCountry());
            $Target->setAlternateAddressStreet($data->getAlternateAddressStreet());
            $Target->setAlternateAddressCity($data->getAlternateAddressCity());
            $Target->setAlternateAddressState($data->getAlternateAddressState());
            $Target->setAlternateAddressPostalCode($data->getAlternateAddressPostalCode());
            $Target->setAlternateAddressCountry($data->getAlternateAddressCountry());
            $Target->setEmailAddress($data->getEmailAddress());
            $Target->setDescription($data->getDescription());
            if (!is_null($form->get('AssignedTo')->getData())) {
                $Target->setAssignedTo($form->get('AssignedTo')->getData()->getFirstName());
                $Target->setAssignedToId($form->get('AssignedTo')->getData()->getId());
            }
            $Target->setDateModified(date('m/d/Y h:i:s a', time()));
            $em->persist($Target);
            $em->flush();


            $thistarget = $this->getDoctrine()
                ->getRepository(Target::class)
                ->findOneByID($Target->getID());

            $this->addFlash('success', 'Target ' . $thistarget->getLastName() . ' Sucessfully Edited');
            return $this->redirectToRoute('gettarget', ['id' => $thistarget->getID()]);
        }


        return $this->render('target/edit.html.twig', array('form' => $form->createView()));
    }


    /**
     * Fetch all instances from table.
     * @Route("/target/all", name="getAlltarget")
     * @return                Response
     */
    public function getAlltarget()
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $em = $this->getDoctrine()->getManager();
        $result = $em->getRepository(Target::class)
            ->findAll();
        if (!$result) {
            $this->addFlash('success', 'There are no created target');
            return $this->render('target/all.html.twig');
        } else {
            return $this->render('target/all.html.twig', ['target' => $result]);
        }
    }


    /**
     * Fetch single instance of target.
     * @Route("/target/{id}", name="gettarget")
     * @param                 $id
     * @return                Response
     */
    public function gettarget($id)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $target = $this->getDoctrine()
            ->getRepository(Target::class)
            ->findOneByID($id);


        if (!$target) {
            $this->addFlash('error', 'Target not found');
            return $this->redirectToRoute('target');
        } else {
            $createdby = $this->getDoctrine()
                ->getRepository(User::class)
                ->findOneByID($target->getCreatedBy());
            $taskrepository = $this->getDoctrine()->getRepository(Task::class);
            $task = $taskrepository->findBy(
                ['RelatedToType' => 'Target',
                    'RelatedToId' => $id,
                ]
            );


            $noterepository = $this->getDoctrine()->getRepository(Note::class);
            $note = $noterepository->findBy(
                ['RelatedToType' => 'Target',
                    'RelatedToId' => $id,
                ]
            );


            $meetingrepository = $this->getDoctrine()->getRepository(Meeting::class);
            $meeting = $meetingrepository->findBy(
                ['RelatedToType' => 'Target',
                    'RelatedToId' => $id,
                ]
            );
            return $this->render('target/view.html.twig', ['target' => $target, 'task' => $task, 'createdby' => $createdby, 'note' => $note, 'meeting' => $meeting]);
        }
    }

    /**
     * Delete simgle instance of target.
     * @Route("/target/del/{id}", name="deltarget")
     * @param                 $id
     * @return                Response
     */
    public function deltarget($id)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $Target = $this->getDoctrine()
            ->getRepository(Target::class)
            ->findOneByID($id);

        if (!$Target) {
            $this->addFlash('error', 'Can not find target');
            return $this->redirectToRoute('getAlltarget');
        } else {
            $em = $this->getDoctrine()->getManager();
            $em->remove($Target);
            $em->flush();
            $this->addFlash('success', 'target sucessfully removed');
            return $this->redirectToRoute('getAlltarget');
        }
    }
}
