<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class TechniquesController extends Controller
{
    /**
     * @Route("/techniques/", name="techniques")
     */
    public function index()
    {
        return $this->render('techniques/index.html.twig', [
            'controller_name' => 'TechniquesController',
        ]);
    }
}
