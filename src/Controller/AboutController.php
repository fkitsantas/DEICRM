<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AboutController extends AbstractController
{
    /**
     * Shows about page.
     * @Route("/about", name="about")
     */

    public function index()
    {
        return $this->render('about/index.html.twig');
    }
}
