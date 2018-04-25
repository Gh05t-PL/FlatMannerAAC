<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ServerInfoController extends Controller
{
    /**
     * @Route("/server/info", name="server_info")
     */
    public function index()
    {
        $serverInfo = [
            'expRate' => 10,
            'magicRate' => 10,
            'skillRate' => 10,
            'pvpLevel' => 10,
        ];




        return $this->render('server_info/index.html.twig', [
            'serverInfo' => $serverInfo,
        ]);
    }
}
