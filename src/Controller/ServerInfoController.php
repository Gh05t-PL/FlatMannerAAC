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
        $serverInfo = [];

        if ( !\file_exists(__DIR__.'\configs.json') )
        {
            $pattern = "/(?:(\w*) *)= *([\w\*\-\+\/\"\'\,\:\@\\\.\!\? ]*)\n/m";
            $path = "C:\Users\wiktor\Desktop\OTS\ots2";
            $file = \file_get_contents($path . "\config.lua");

            $arrayTemp = [];
            \preg_match_all($pattern,$file,$arrayTemp, PREG_SET_ORDER);
            $file = null;
            //var_dump($arrayTemp);
            $array = [];
            $i = 0;
            foreach ($arrayTemp as $key => $value) {
                    $array[$value[1]] = $value[2];
            }
            $json = \json_encode($array);

            //var_dump($json);

            \file_put_contents(__DIR__.'\configs.json', $json);
        }
        else
        {
            $json = json_decode(\file_get_contents(__DIR__.'\configs.json'));

            $serverInfo = [
                'exp Rate' => $json->rateExperience,
                'magicRate' => $json->rateMagic,
                'skillRate' => $json->rateSkill,
                'pvpLevel' => $json->protectionLevel,
            ];
        }


        
        return $this->render('server_info/index.html.twig', [
            'serverInfo' => $serverInfo,
        ]);
    }
}
