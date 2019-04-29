<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Entity\Interaction;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Form\FormData;
use App\Form\Interaction\InteractionForm;

class InteractionController extends AbstractController
{


/**
 * @Route("/interaction", name="interaction")
 * @param           Request $request
 * @return          \Symfony\Component\HttpFoundation\RedirectResponse|Response
 */
    public function interaction(Request $request)
    {
        $FormData = new FormData();

        $interactionForm = $this->createForm(InteractionForm::class, $FormData);

        $interactionForm->handleRequest($request);

        if ($interactionForm->isSubmitted() && $interactionForm->isValid()) {
            $data = $interactionForm->getData();

            $data = $interactionForm->getData();
            $em = $this->getDoctrine()->getManager();
            $Interaction = new Interaction();

            if ($interactionForm->isSubmitted() && $interactionForm->isValid()) {
                $data = $interactionForm->getData();

                $em = $this->getDoctrine()->getManager();
                $Interaction = new Interaction();
                $Interaction->setMediaType($data->MediaType);
                $Interaction->setType($data->MediaType);
                $Interaction->setLineDurationL($data->LineDurationL);
                $Interaction->setLineDurationS($data->LineDurationS);

                $Interaction->setDirection($data->Direction);

                $Interaction->setRemoteAddress($data->RemoteAddress);

                $Interaction->setDnis($data->Dnis);

                $Interaction->setType($data->Type);

                $Interaction->setFromDate($data->FromDate);

                $Interaction->setToDate($data->ToDate);

                $Interaction->setFromTime($data->FromTime);

                $Interaction->setToTime($data->ToTime);

                $Interaction->setWhoTo($data->WhoTo);

                $Interaction->setWhoBy($data->WhoBy);

                $Interaction->setWho($this->getUser()->getId());

                $em->persist($Interaction);
                $em->flush();

                $this->addFlash('success', 'Sucessfully Added');

                if ($data->Type == "contact") {
                    return $this->redirectToRoute('getcontact', ['id' => $data->WhoTo]);
                } elseif ($data->Type == "account") {
                    return $this->redirectToRoute('getaccount', ['id' => $data->WhoTo]);
                } elseif ($data->Type == "lead") {
                    return $this->redirectToRoute('getlead', ['id' => $data->WhoTo]);
                } else {
                    return $this->redirectToRoute('dashboard');
                }
            }
        }

        return $this->redirectToRoute('dashboard');
    }
}
