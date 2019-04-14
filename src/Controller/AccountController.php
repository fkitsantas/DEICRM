<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\FormData;
use App\Form\LoginForm;

class AccountController extends Controller
{
    /**
     * @Route("/account", name="account")
     */
    public function index()
    {
        return $this->render('account/index.html.twig', [
            'controller_name' => 'AccountController',
        ]);
    }



    /**
     * @Route("/", name="login")
     * @param           Request $request
     * @return          \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function login(Request $request)
    {
        $FormData = new FormData();

        $form = $this->createForm(LoginForm::class, $FormData);

        if ($form->isSubmitted() && $form->isValid()) {
            /**
             * @var AuditForm $data
             */
        }


        return $this->render(
                  'home_page/index.html.twig',
        array('form' => $form->createView())
      );
    }
}
