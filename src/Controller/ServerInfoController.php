<?php

namespace App\Controller;

use App\Utils\ConfigsParser;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ServerInfoController extends Controller
{
    /**
     * @Route("/server/info", name="server_info")
     */
    public function index()
    {
        $configParser = new ConfigsParser();
        $serverInfo = $configParser->parse();

        $serverInfo = [
            'Exp Rate' => $serverInfo['rateExperience'],
            'Magic Rate' => $serverInfo['rateMagic'],
            'Skill Rate' => $serverInfo['rateSkill'],
            'PVP Level' => $serverInfo['protectionLevel']
        ];


        return $this->render('server_info/index.html.twig', [
            'serverInfo' => $serverInfo,
        ]);
    }
}
