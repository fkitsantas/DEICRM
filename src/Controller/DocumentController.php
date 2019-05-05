<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Document;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Form\FormData;
use App\Form\Document\DocumentForm;
use App\Form\Document\DocumentEdit;
use App\Form\Document\DocumentSearchForm;
use App\Entity\Task;
use App\Entity\User;
use App\Entity\Contact;
use App\Entity\Account;
use App\Entity\Target;
use App\Entity\Lead;
use App\Entity\Opportunities;
use App\Entity\Campaigns;
use App\Service\FileUploader;
use Symfony\Component\HttpFoundation\File\File;

class DocumentController extends AbstractController
{
    /**
     * Shows document index and searchbox.
     * @Route("/document", name="document")
     */
    public function index(Request $request)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $FormData = new FormData();
        $form = $this->createForm(documentSearchForm::class, $FormData);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $document = $this->getDoctrine()
                ->getRepository(Document::class)
                ->findByName($data->Search);

            if (!$document) {
                $this->addFlash('error', 'No document was found, Try Searching Again');
                return $this->render('document/index.html.twig', array('form' => $form->createView()));
            } else {
                return $this->render('document/index.html.twig', array('form' => $form->createView(), 'document' => $document, 'searchfor' => $data->Search));
            }
        }

        return $this->render('document/index.html.twig', ['form' => $form->createView()]);
    }


    /**
     * Allows creating of a new document record, does two things
     * 1) Saves record into the document database
     * 2) Saves file into the specified file path
     * @Route("/document/create", name="createdocument")
     * @param           Request $request
     * @return          \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function createdocument(Request $request, FileUploader $fileUploader)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        if (!$this->isGranted('ROLE_ADMIN') && !$this->isGranted('ROLE_MANAGER')) {
            $this->addFlash('error', 'You dont have permission to acccess this page');

            return $this->redirectToRoute('document');
        }


        $FormData = new FormData();
        $form = $this->createForm(DocumentForm::class, $FormData);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $Document = new Document();


            $Document->setDocumentName($data->DocumentName);
            $file = $data->FileName;
            $fileName = $fileUploader->upload($file);
            $Document->setFileName($fileName);
            $Document->setCategory($data->Category);
            $Document->setSubCategory($data->SubCategory);
            $Document->setDocumentType($data->DocumentType);
            $Document->setPublishDate($data->PublishDate);
            $Document->setExpirationDate($data->ExpirationDate);
            $Document->setRevision($data->Revision);
            $Document->setDescription($data->Description);
            $Document->setStatus($data->Status);
            $Document->setDateCreated(date('m/d/Y h:i:s a', time()));
            $Document->setCreatedBy($this->getUser()->getId());
            $em->persist($Document);
            $em->flush();

            $thisdocument = $this->getDoctrine()
                ->getRepository(Document::class)
                ->findOneByID($Document->getID());

            $this->addFlash('success', 'Document ' . $thisdocument->getDocumentName() . ' Sucessfully Created');
            return $this->redirectToRoute('getdocument', ['id' => $thisdocument->getID()]);
        }


        return $this->render('Document/create.html.twig', array('form' => $form->createView()));
    }


    /**
     * Allows editing of already saved documents by administrator and managers
     * @Route("/document/edit/{id}", name="editdocument")
     * @param           Request $request
     * @return          \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function editdocument(Request $request, $id)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $Document = $this->getDoctrine()
            ->getRepository(Document::class)
            ->findOneByID($id);


        if (!$Document) {
            $this->addFlash('error', 'This document does not exist');

            return $this->render('document/index.html.twig');
        }

        if (!$this->isGranted('ROLE_ADMIN') && !$this->isGranted('ROLE_MANAGER') && $this->getUser()->getId() !== $Document->getAssignedToId()) {
            $this->addFlash('error', 'You dont have permission to acccess this page');

            return $this->redirectToRoute('document');
        }


        $filename = $Document->getFileName();
        $file = new File($this->getParameter('brochures_directory') . '/' . $Document->getFileName());
        $Document->setFileName($file);
        $form = $this->createForm(DocumentEdit::class, $Document);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $Document->setDocumentName($data->getDocumentName());
            $Document->setFileName($filename);

            $Document->setCategory($data->getCategory());
            $Document->setSubCategory($data->getSubCategory());
            $Document->setPublishDate($data->getPublishDate());
            $Document->setExpirationDate($data->getExpirationDate());
            $Document->setRevision($data->getRevision());
            $Document->setDocumentType($data->getDocumentType());
            $Document->setDescription($data->getDescription());

            $Document->setStatus($data->getStatus());
            $Document->setDateModified(date('m/d/Y h:i:s a', time()));

            $em->persist($Document);
            $em->flush();

            $thisdocument = $this->getDoctrine()
                ->getRepository(Document::class)
                ->findOneByID($Document->getID());

            $this->addFlash('success', 'Document ' . $thisdocument->getDocumentName() . ' Sucessfully Edited');
            return $this->redirectToRoute('getdocument', ['id' => $thisdocument->getID()]);
        }


        return $this->render('Document/edit.html.twig', array('form' => $form->createView()));
    }


    /**
     * Fetches all record in the database.
     * @Route("/document/all", name="getAlldocument")
     * @return                Response
     */
    public function getAlldocument()
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $em = $this->getDoctrine()->getManager();
        $result = $em->getRepository(Document::class)
            ->findAll();
        if (!$result) {
            $this->addFlash('success', 'There are no created document');
            return $this->render('Document/all.html.twig');
        } else {
            return $this->render('Document/all.html.twig', ['document' => $result]);
        }
    }


    /**
     * Fetch just one record of document from the database.
     * @Route("/document/{id}", name="getdocument")
     * @param                 $id
     * @return                Response
     */
    public function getdocument($id)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $document = $this->getDoctrine()
            ->getRepository(Document::class)
            ->findOneByID($id);


        if (!$document) {
            $this->addFlash('error', 'Document not found');
            return $this->redirectToRoute('document');
        } else {
            $createdby = $this->getDoctrine()
                ->getRepository(User::class)
                ->findOneByID($document->getCreatedBy());

            return $this->render('Document/view.html.twig', ['document' => $document, 'createdby' => $createdby]);
        }
    }

    /**
     * Delete document
     * @Route("/document/del/{id}", name="deldocument")
     * @param                 $id
     * @return                Response
     */
    public function deldocument($id)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $Document = $this->getDoctrine()
            ->getRepository(Document::class)
            ->findOneByID($id);

        if (!$Document) {
            $this->addFlash('error', 'Can not find document');
            return $this->redirectToRoute('getAlldocument');
        } else {
            $em = $this->getDoctrine()->getManager();
            $em->remove($Document);
            $em->flush();
            $this->addFlash('success', 'document sucessfully removed');
            return $this->redirectToRoute('getAlldocument');
        }
    }
}
