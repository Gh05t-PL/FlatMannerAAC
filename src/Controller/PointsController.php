<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

use App\Utils\Strategy\StrategyClient;

use App\Entity\FmaacShopLogs;

use App\Utils\Configs;

class PointsController extends Controller
{

    private $config = [
        'availableSystems' => [
            'paygol' => true,
            'paypal' => false,
            'microsms' => true,
        ],
        'paygol' => [
            'serviceId' => 'xxxxxx',
            'returnUrl' => "http://217.182.78.52/points/paygol",
            'cancelUrl' => "http://217.182.78.52/points/paygol",
        ],
        'microsms' => [
            'userid' => 'xxxxxx',
            'serviceid' => 'xxxxxx',
            'points' => [       # this system is for SMS PREMIUM STANDARD go check PaymentCatcherController for SMS PREMIUM PROFESJONALNY
                '71480' => 200, # key=sms number value=points
                '72480' => 200,
                '73480' => 200,
                '74480' => 2,
                '75480' => 2,
                '76480' => 2,
                '79480' => 2,
                '91400' => 2,
                '91900' => 2,
                '92022' => 2,
                '92521' => 2,
                '92550' => 2,
            ],
        ],

    ];


    /**
     * @Route("/points", name="points")
     */
    public function points(SessionInterface $session, Request $request)
    {
        return $this->render('points/providers.html.twig', [
            'availableSystems' => $this->config['availableSystems'],
        ]);
    }


    /**
     * @Route("/points/{provider}", name="points_buy", requirements={
     *      "provider"="paygol|paypal|microsms"
     * }))
     */
    public function pointsBuy($provider, SessionInterface $session, Request $request, StrategyClient $strategy)
    {

        if ( $session->get('account_id') !== null )
        {
            $errors = [];
            $account = $strategy->getAccounts()->getAccountBy(['id' => $session->get('account_id')]);


            if ( $provider == "paygol" )
            {

            } elseif ( $provider == "microsms" )
            {
                $form = $this->createFormBuilder()
                    ->add('account', TextType::class, ['label' => 'Account Name', 'data' => $account->getName(), 'attr' => ['display' => 'block']])
                    ->add('code', TextType::class, ['label' => 'SMS Code', 'attr' => ['display' => 'block']])
                    ->add('submit', SubmitType::class, ['label' => 'Submit'])
                    ->getForm();

                $form->handleRequest($request);

                if ( $form->isSubmitted() && $form->isValid() )
                {
                    $formData = $form->getData();
                    $api = @file_get_contents("http://microsms.pl/api/v2/multi.php?userid=" . $this->config['microsms']['userid'] . "&code=" . $formData['code'] . '&serviceid=' . $this->config['microsms']['serviceid']);
                    if ( $api == null || $api == false )
                    {
                        $errors[] = "Can't connect with MicroSMS";
                        return $this->render('points/buy.html.twig', [
                            'provider' => 'microsms',
                            'account' => $account,
                            'config' => $this->config,
                            'form' => $form->createView(),
                            'errors' => $errors,
                        ]);
                    }
                    $api = json_decode($api);
                    if ( !is_object($api) )
                        $errors[] = "Can't read payment information";
                    if ( isset($api->error) && $api->error )
                        $errors[] = 'Error Code: ' . $api->error->errorCode . ' - ' . $api->error->message;
                    if ( isset($api->connect) && $api->connect == false )
                        $errors[] = 'Error Code: ' . $api->data->errorCode . ' - ' . $api->data->message;
                    if ( isset($api->data->status) && $api->data->status != 1 )
                        $errors[] = "Your Code {$formData['code']} is Invalid";


                    // No errors found
                    if ( empty($errors) )
                    {

                        $em = $this->getDoctrine()->getManager();

                        $account = $strategy->getAccounts()->getAccountBy(['name' => $formData['account']]);
                        if ( $account == null )
                        {
                            $account = $strategy->getAccounts()->getAccountBy(['name' => '1']);
                        }

                        $shopLog = new FmaacShopLogs();
                        $shopLog->setPoints($this->config['microsms']['points'][$api->data->number]);
                        $shopLog->setDatetime(new \DateTime());
                        $shopLog->setAccount($account);

                        $account->setPoints($account->getPoints() + $this->config['microsms']['points'][$api->data->number]);
                        $em->persist($account);
                        $em->persist($shopLog);
                        $em->flush();
                    }
                    return $this->render('points/buy.html.twig', [
                        'provider' => $provider,
                        'account' => $account,
                        'config' => $this->config,
                        'errors' => $errors,
                        'form' => $form->createView(),
                    ]);
                }
                return $this->render('points/buy.html.twig', [
                    'provider' => $provider,
                    'account' => $account,
                    'config' => $this->config,
                    'errors' => $errors,
                    'form' => $form->createView(),
                ]);
            }

            return $this->render('points/buy.html.twig', [
                'provider' => $provider,
                'account' => $account,
                'config' => $this->config,
                'errors' => $errors,
            ]);

        } else
        {

            return $this->redirectToRoute('account_login', [], 301);
        }
    }
}