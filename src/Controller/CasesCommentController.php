<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Entity\CasesComment;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Form\FormData;
use App\Form\Cases\CasesCommentForm;
use App\Service\RolesToText;

class CasesCommentController extends AbstractController
{


    /**
     * Show the form to add comment to a case id.
     * @Route("/casescomment", name="casescomment")
     * @param           Request $request
     * @return          \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function casescomment(Request $request, RolesToText $rolesToText)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $FormData = new FormData();

        $casescommentForm = $this->createForm(CasesCommentForm::class, $FormData);

        $casescommentForm->handleRequest($request);

        if ($casescommentForm->isSubmitted() && $casescommentForm->isValid()) {
            $data = $casescommentForm->getData();
            $data = $casescommentForm->getData();
            $em = $this->getDoctrine()->getManager();
            $CasesComment = new CasesComment();

            if ($casescommentForm->isSubmitted() && $casescommentForm->isValid()) {
                $data = $casescommentForm->getData();

                $em = $this->getDoctrine()->getManager();
                $CasesComment = new CasesComment();

                $type = implode("|", $this->getUser()->getRoles());

                if ($type == "ROLE_ADMIN") {
                    $roletype = "ADMINISTRATOR";
                } elseif ($type == "ROLE_MANAGER") {
                    $roletype = "MANAGER";
                } else {
                    $roletype = "EMPLOYEE";
                }


                $CasesComment->setType($roletype);

                $CasesComment->setMessage($data->Comment);

                $CasesComment->setCaseId($data->CaseId);

                $CasesComment->setAddedById($data->AddedById);

                $CasesComment->setAccountId($data->AccountId);

                $CasesComment->setAccountName($data->AccountName);

                $CasesComment->setAddedBy($data->AddedBy);


                $CasesComment->setDate($data->Date);


                $em->persist($CasesComment);
                $em->flush();

                $this->addFlash('success', 'Sucessfully Added');


                return $this->redirectToRoute('getaccount', ['id' => $data->AccountId]);
            }
        }

        return $this->redirectToRoute('getAllaccount');
    }
}
