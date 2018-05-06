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
use App\Entity\Accounts;
use App\Entity\Players;
use App\Entity\FmaacLogs;
use App\Entity\FmaacLogsActions;

class AccountController extends Controller
{



    /**
     * @Route("/account", name="account")
     */
    public function account(SessionInterface $session){

        // if session['account_id'] !== NULL AND loginIp == CurrentIp then
        // LOGGED IN
        if ( $session->get('account_id') !== NULL ){

            $account = $this->getDoctrine()
                ->getRepository(\App\Entity\Accounts::class)
            ->find($session->get('account_id'));

            $accountChars = $this->getDoctrine()
                ->getRepository(\App\Entity\Players::class)
            ->findBy(['account' => $session->get('account_id')]);

            return $this->render('account/account.html.twig', [
                "account" => $account,
                "accountChars" => $accountChars
            ]);
        }
        else{
            
            return $this->redirectToRoute('account_login', [], 301);
        }
    }


    /**
     * @Route("/account/logout", name="account_logout")
     */
    public function logout(SessionInterface $session){

        // if session['account_id'] !== NULL AND loginIp == CurrentIp then
        if ( $session->get('account_id') !== NULL ){

            $session->remove('account_id');
            // no nie jestes zalogowany a to zle, przekierowuje 301 perm
            return $this->redirectToRoute('account_login', [], 301);
        }
    }


    /**
     * @Route("/account/{id}", name="account_index", requirements={"id"="\d+"})
     */
    public function get($id){

        $account = $this->getDoctrine()
            ->getRepository(\App\Entity\Accounts::class)
        ->find($id);

        return $this->render('account/index.html.twig', [
            'account' => $account,
        ]);
    }



    /**
     * @Route("/account/login", name="account_login")
     */
    public function login(Request $request, SessionInterface $session){
        
        $form = $this->createFormBuilder()
            ->add('Account', TextType::class)
            ->add('Password', TextType::class)
            ->add('Login', SubmitType::class, array('label' => 'Login'))
        ->getForm();

        $form->handleRequest($request);
        $errors =[];
        if ( $form->isSubmitted() && $form->isValid() ) {
            //echo $request;


            // Checking for errors
            if ( $account = $this->getDoctrine()->getRepository(Accounts::class)->findOneBy(['name' => $form->getData()['Account'],'password' => sha1($form->getData()['Password'])]) === NULL )
                $errors[] = "Wrong Account Name or/and Password";

            // No errors found
            if ( empty($errors) ){
                $account = $this->getDoctrine()
                    ->getRepository(Accounts::class)
                ->findOneBy([
                    'name' => $form->getData()['Account'],
                    'password' => sha1($form->getData()['Password'])
                ]);


                if ( $account !== NULL ){
                    $session->set('account_id', $account->getId());
                    echo "SETTED ".$account->getId();
                }
                return $this->redirectToRoute('account');
            }
        }


        return $this->render('account/account_login.html.twig', [
            'form' => $form->createView(),
            'request' => $request,
            'errors' => $errors
        ]);
    }



    /**
     * @Route("/account/create", name="account_create")
     */
    public function create(Request $request){
        
        $form = $this->createFormBuilder()
            ->add('account', TextType::class, ['label' => 'Account Name', 'attr' => ['display' => 'block']])
            ->add('password', TextType::class, ['label' => 'Password'])
            ->add('repeatPassword', TextType::class, ['label' => 'Repeat Password'])
            ->add('email', TextType::class, ['label' => 'E-mail'])
            ->add('repeatEmail', TextType::class, ['label' => 'Repeat E-mail'])
            ->add('Create', SubmitType::class, ['label' => 'Create Account'])
        ->getForm();

        $form->handleRequest($request);

        $errors = [];
        if ( $form->isSubmitted() && $form->isValid() ) {
            $formData = $form->getData();
            
            // Checking for errors
            if ( $this->getDoctrine()->getRepository(Accounts::class)->findOneBy(['name' => $formData['account']]) !== NULL )
                $errors[] = "Account Name taken";
            if ( $formData['password'] != $formData['repeatPassword'])
                $errors[] = "Passwords don't match";
            if ( $formData['email'] != $formData['repeatEmail'])
                $errors[] = "E-mails don't match";

            // No errors found
            if ( empty($errors) ){
                $account = new Accounts();
                $account->setName($formData['account']);
                $account->setPassword($formData['password']);
                $account->setEmail($formData['email']);
                $em = $this->getDoctrine()->getManager();

                $em->persist($account);
                

                //LOG ACTION
                $action = $this->getDoctrine()->getRepository(FmaacLogsActions::class)->find(1); // action 1 = create account
                $log = new FmaacLogs();
                $log->setAction($action)
                    ->setDatetime(new \DateTime())
                ->setIp($_SERVER['REMOTE_ADDR']);

                $em->persist($log);
                $em->flush();



                return $this->redirectToRoute('account_login');
                
            }

            
        }

        return $this->render('account/account_create.html.twig', [
            'form' => $form->createView(),
            'request' => $request,
            'errors' => $errors,
        ]);
    }



    /**
     * @Route("/account/create/character", name="account_create_character")
     */
    public function createCharacter(Request $request, SessionInterface $session){
        // this variable defines how big level is on start

        /**
         * [TODO] get vocations, gains of cap and health/mana from vocation.xml
         */
        $startStats = [
            'level' => 8,
            'magiclevel' => 5,
            'cap' => 200,
            'health' => 250,
            'mana' => 250,
            'skill' => 10
        ];
        $vocations = [
            'Sorcerer' => 1,
            'Druid' => 2,
            'Paladin' => 3,
            'Knight' => 4
        ];
        $cities = [
            "Thais" => 1,
            "Kazordoon" => 2,
            "Venore" => 3,
        ];
        $citiesPos = [
            1 => [
                "x" => 95,
                "y" => 126,
                "z" => 7,
            ],
            2 => [
                "x" => 201,
                "y" => 497,
                "z" => 7,
            ],
            3 => [
                "x" => 201,
                "y" => 497,
                "z" => 7,
            ],
        ];



        if ($session->get('account_id') !== NULL){
            $form = $this->createFormBuilder()
                ->add('name', TextType::class, ['label' => 'Name', 'attr' => ['display' => 'block']])
                ->add('sex', ChoiceType::class, [
                    'label' => 'Sex',
                    'choices' => [
                        'Male' => 1,
                        'Female' => 0
                    ]
                ])
                ->add('vocation', ChoiceType::class, [
                    'label' => 'Vocation',
                    'choices' => $vocations
                ])
                ->add('city', ChoiceType::class, [
                    'label' => 'City',
                    'choices' => $cities,
                ])
                ->add('Create', SubmitType::class, ['label' => 'Create'])
            ->getForm();

            $form->handleRequest($request);

            $errors = [];
            if ( $form->isSubmitted() && $form->isValid() ) {
                $formData = $form->getData();
            
                // Checking for errors
                if ( $this->getDoctrine()->getRepository(Players::class)->findOneBy(['name' => $formData['name']]) !== NULL )
                    $errors[] = "Name taken";
                if ( strlen($formData['name']) > 20 )
                    $errors[] = "Name longer than 20 char";
                if ( preg_match("/^([A-z ])+$/", $formData['name']) === 0 )
                    $errors[] = "Name can only contain letters from [A-Z][a-z] and spaces";
                    //var_dump(preg_match("/^([A-z ])+$/", $formData['name']));


                // No errors found
                if ( empty($errors) ){

                    $player = new Players();

                    $player->setName(ucwords($formData['name']));
                    $player->setSex($formData['sex']);
                    $player->setVocation($formData['vocation']);
                    $player->setAccount($this->getDoctrine()->getRepository(Accounts::class)->find($session->get('account_id')));
                    $player->setLevel($startStats['level']);
                    $player->setCap($startStats['cap']);
                    $player->setMaglevel($startStats['magiclevel']);
                    $player->setHealth($startStats['health']);
                    $player->setHealthmax($startStats['health']);
                    $player->setMana($startStats['mana']);
                    $player->setManamax($startStats['mana']);

                    $player->setTownId($formData['city']);
                    $player->setPosx($citiesPos[$formData['city']]['x']);
                    $player->setPosy($citiesPos[$formData['city']]['y']);
                    $player->setPosz($citiesPos[$formData['city']]['z']);

                    function expToLevel($level){
                        return ((50 * ($level - 1)**3 - 150 * ($level - 1)**2 + 400 * ($level - 1)) / 3);
                    }

                    $player->setExperience(expToLevel($startStats['level']));

                    //SKILLS
                    $player->setSkillFist($startStats['skill'])
                        ->setSkillClub($startStats['skill'])
                        ->setSkillSword($startStats['skill'])
                        ->setSkillAxe($startStats['skill'])
                        ->setSkillDist($startStats['skill'])
                        ->setSkillShielding($startStats['skill'])
                    ->setSkillFishing($startStats['skill']);

                    $em = $this->getDoctrine()->getManager();
                    $em->persist($player);
                    $em->flush();

                    //LOG ACTION
                    $action = $this->getDoctrine()->getRepository(FmaacLogsActions::class)->find(3); // action 3 = create char
                    $log = new FmaacLogs();
                    $log->setAction($action)
                        ->setDatetime(new \DateTime())
                    ->setIp($_SERVER['REMOTE_ADDR']);

                    $em->persist($log);
                    $em->flush();

                    //today exp
                    $conn = $em->getConnection();
                    $conn->insert('today_exp', [
                        'id' => null,
                        'exp' => expToLevel($startStats['level']),
                        'player_id' => $player->getId()
                    ]);

                    
                    return $this->redirectToRoute('account');
                }

                return $this->render('account/account_create_character.html.twig', [
                    'form' => $form->createView(),
                    'request' => $request,
                    'errors' => $errors,
                ]);
            }
            return $this->render('account/account_create_character.html.twig', [
                'form' => $form->createView(),
                'request' => $request,
                'errors' => $errors,
            ]);
        }
        
        else{
            return $this->redirectToRoute('account_login');
        }
    }

    /**
     * @Route("/account/change/password", name="account_change_password")
     */
    public function changePassword(Request $request, SessionInterface $session){
        $action = 'Password';
        if ( $session->get('account_id') !== NULL ){

            $form = $this->createFormBuilder()
                ->add('currentPassword', TextType::class, ['label' => 'Current Password'])
                ->add('password', TextType::class, ['label' => 'Password'])
                ->add('repeatPassword', TextType::class, ['label' => 'Repeat Password'])
                ->add('Create', SubmitType::class, ['label' => 'Change'])
            ->getForm();

            $form->handleRequest($request);

            $errors = [];
            if ( $form->isSubmitted() && $form->isValid() ) {
                $formData = $form->getData();
                
                // Checking for errors
                if ( $this->getDoctrine()->getRepository(Accounts::class)->findOneBy(['id' => $session->get('account_id'), 'password' => $formData['password']]) !== NULL )
                    $errors[] = "Password incorrect";
                if ( $formData['password'] != $formData['repeatPassword'])
                    $errors[] = "Passwords don't match";

                // No errors found
                if ( empty($errors) ){
                    $account = $this->getDoctrine()->getRepository(Accounts::class)->find($session->get('account_id'));

                    $account->setPassword($formData['password']);

                    $em = $this->getDoctrine()->getManager();
                    $em->persist($account);
                    $em->flush();

                    //LOG ACTION
                    $action = $this->getDoctrine()->getRepository(FmaacLogsActions::class)->find(6); // action 6 = account changes
                    $log = new FmaacLogs();
                    $log->setAction($action)
                        ->setDatetime(new \DateTime())
                    ->setIp($_SERVER['REMOTE_ADDR']);

                    $em->persist($log);
                    $em->flush();

                    return $this->redirectToRoute('account');
                }
            }
            return $this->render('account/account_change.html.twig', [
                'form' => $form->createView(),
                'request' => $request,
                'action' => $action,
                'errors' => $errors,
            ]);
        }else{
            return $this->redirectToRoute('account_login');
        }
    }


    /**
     * @Route("/account/change/email", name="account_change_email")
     */
    public function changeEmail(Request $request, SessionInterface $session){
        $action = 'Email';
        if ( $session->get('account_id') !== NULL ){

            $form = $this->createFormBuilder()
                ->add('email', TextType::class, ['label' => 'New Email'])
                ->add('repeatEmail', TextType::class, ['label' => 'Repeat Email'])
                ->add('password', TextType::class, ['label' => 'Password'])
                ->add('Create', SubmitType::class, ['label' => 'Change'])
            ->getForm();

            $form->handleRequest($request);

            $errors = [];
            if ( $form->isSubmitted() && $form->isValid() ) {
                $formData = $form->getData();
                
                // Checking for errors
                if ( $this->getDoctrine()->getRepository(Accounts::class)->findOneBy(['id' => $session->get('account_id'), 'password' => $formData['password']]) == NULL )
                    $errors[] = "Password incorrect";
                if ( $formData['email'] != $formData['repeatEmail'])
                    $errors[] = "Emails don't match";

                // No errors found
                if ( empty($errors) ){
                    $account = $this->getDoctrine()->getRepository(Accounts::class)->find($session->get('account_id'));

                    $account->setEmail($formData['email']);

                    $em = $this->getDoctrine()->getManager();
                    $em->persist($account);
                    $em->flush();

                    //LOG ACTION
                    $action = $this->getDoctrine()->getRepository(FmaacLogsActions::class)->find(6); // action 6 = account changes
                    $log = new FmaacLogs();
                    $log->setAction($action)
                        ->setDatetime(new \DateTime())
                    ->setIp($_SERVER['REMOTE_ADDR']);

                    $em->persist($log);
                    $em->flush();

                    return $this->redirectToRoute('account');
                }
            }
            return $this->render('account/account_change.html.twig', [
                'form' => $form->createView(),
                'request' => $request,
                'action' => $action,
                'errors' => $errors,
            ]);
        }else{
            return $this->redirectToRoute('account_login');
        }
    }

}
