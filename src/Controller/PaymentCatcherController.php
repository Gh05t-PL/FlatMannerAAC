<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use App\Utils\Strategy\StrategyClient;

use App\Entity\FmaacShopLogs;

use App\Utils\Configs;

class PaymentCatcherController extends Controller
{

    private $config = [
        'paygol' => [
            'secretKey' => "xxxxxx",
            'points' => [
                '1.30' => 10, # key=from price value=points
                '2.45' => 22,
                '5.00' => 60,
            ],
        ],
        'microsms' => [
            'userid' => 'xxxxxx',
            'points' => [       # this system is for SMS PREMIUM PROFESJONALNY
                '71480' => 1, # key=sms number value=points
                '72480' => 2,
                '73480' => 3,
                '74480' => 4,
                '75480' => 5,
                '76480' => 6,
                '79480' => 7,
                '91400' => 8,
                '91900' => 9,
                '92022' => 10,
                '92521' => 11,
                '92550' => 12,
            ],
        ],

    ];


    /**
     * @Route("/payment/catcher/{provider}", name="payment_catcher", requirements={
     *      "provider"="paygol|paypal|microsms"
     * })))
     */
    public function catcher($provider, Request $request, StrategyClient $strategy)
    {

        if ( $provider == "paygol" )
        {
            // if request secret key is not same (type and value) of config then return error and stop script
            if ( $request->query->get('key') !== $this->config['paygol']['secretKey'] )
                return new Response("Error");

            $account = $strategy->getAccounts()->getAccountBy(['name' => $request->query->get('custom')]);

            $account->setPoints($account->getPoints() + $this->config['paygol']['points'][$request->query->get('frmprice')]);
            $em = $this->getDoctrine()->getManager();

            $em->persist($account);
            $em->flush();

            $shopLog = new FmaacShopLogs();
            $shopLog->setPoints($this->config['paygol']['points'][$request->query->get('frmprice')]);
            $shopLog->setDatetime(new \DateTime());
            $shopLog->setAccount($account);

            $em->persist($shopLog);
            $em->flush();
            return new Response("OK");

        } elseif ( $provider == "microsms" )
        {
            if ( !in_array($_SERVER['REMOTE_ADDR'], explode(',', file_get_contents('http://microsms.pl/psc/ips/'))) == true )
                return new Response("ERROR 1");
            if ( $request->request->get('userID') !== $this->config['microsms']['userid'] )
                return new Response("ERROR 2");


            if ( strpos($request->request->get('text'), ".") )
            {
                $txt = explode('.', $request->request->get('text'));
                if ( !isset($txt[1]) )
                {
                    $txt = explode(' ', $request->request->get('text'));
                }
            } else
            {
                $txt[0] = $request->request->get('text');
                $txt[1] = '';
            }


            $em = $this->getDoctrine()->getManager();

            $account = $strategy->getAccounts()->getAccountBy(['name' => $txt[2]]);
            if ( $account == null )
            {
                $account = $strategy->getAccounts()->getAccountBy(['name' => '1']);
            }

            $shopLog = new FmaacShopLogs();
            $shopLog->setPoints($this->config['microsms']['points'][$request->request->get('numberSMS')]);
            $shopLog->setDatetime(new \DateTime());
            $shopLog->setAccount($account);

            $account->setPoints($account->getPoints() + $this->config['microsms']['points'][$request->request->get('numberSMS')]);
            $em->persist($account);
            $em->persist($shopLog);
            $em->flush();
            return new Response("OK");
        }

        return new Response("OK");
    }
}
