<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BanishmentsController extends Controller
{
    /**
     * @Route("/banishments", name="banishments")
     */
    public function index()
    {
        return $this->render('banishments/index.html.twig', [
            'controller_name' => 'BanishmentsController',
        ]);
    }
}
