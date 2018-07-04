<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Doctrine\ORM\Query\ResultSetMapping;

use App\Utils\Strategy\StrategyClient;

use App\Utils\Configs;

class BanishmentsController extends Controller
{
    /**
     * @Route("/bans", name="banishments")
     */
    public function bans()
    {

        $strategy = new StrategyClient($this->getDoctrine());

        $result = $strategy->bans->getBansList();

        return $this->render('banishments/bans.html.twig', [
            'controller_name' => 'PlayersController',
            'bans' => @$result,
        ]);
    }
}
