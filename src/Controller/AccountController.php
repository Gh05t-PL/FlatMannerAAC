<?php

namespace App\Controller;

use App\Utils\ActionLogger;
use App\Utils\LoginHelper;
use App\Utils\Validators\AccountValidator;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

use App\Entity\FmaacLogs;
use App\Entity\FmaacLogsActions;

use Doctrine\ORM\Query\ResultSetMapping;

use App\Utils\Strategy\StrategyClient;

use App\Utils\Configs;

class AccountController extends Controller
{


    /**
     * @Route("/account", name="account")
     */
    public function account(SessionInterface $session, StrategyClient $strategy)
    {

        // if session['account_id'] !== NULL AND loginIp == CurrentIp then
        // LOGGED IN
        if ( $session->get('account_id') !== null )
        {

            $account = $strategy->getAccounts()->getAccountById($session->get('account_id'));

            $accountChars = $strategy->getAccounts()->getAccountChars($session->get('account_id'));

            return $this->render('account/account.html.twig', [
                "account" => $account,
                "accountChars" => $accountChars,
            ]);
        } else
        {

            return $this->redirectToRoute('account_login', [], 301);
        }
    }


    /**
     * @Route("/account/logout", name="account_logout")
     */
    public function logout(LoginHelper $loginHelper)
    {

        // if session['account_id'] !== NULL AND loginIp == CurrentIp then
        if ( $loginHelper->isLoggedIn() )
        {
            $loginHelper->logout();

            return $this->redirectToRoute('account_login', [], 301);
        } else
        {
            return $this->redirectToRoute('account_login', [], 301);
        }
    }


    /**
     * @Route("/account/login", name="account_login")
     */
    public function login(Request $request, StrategyClient $strategy, AccountValidator $validator, LoginHelper $loginHelper)
    {

        $form = $this->createFormBuilder()
            ->add('Account', TextType::class, ['attr' => ['display' => 'block']])
            ->add('Password', PasswordType::class, ['attr' => ['display' => 'block']])
            ->add('Login', SubmitType::class, ['label' => 'Login'])
            ->getForm();

        $form->handleRequest($request);
        $errors = [];
        if ( $form->isSubmitted() && $form->isValid() )
        {

            // Checking for errors
            if ( !$validator->isValidCredentials($form->getData()['Account'], $form->getData()['Password']) )
                $errors[] = "Wrong Account Name or/and Password";

            // No errors found
            if ( empty($errors) )
            {
                $account = $strategy->getAccounts()->getAccountBy([
                    'name' => $form->getData()['Account'],
                    'password' => $form->getData()['Password'],
                ]);

                $loginHelper->login($account->getId());

                return $this->redirectToRoute('account');
            }
        }


        return $this->render('account/account_login.html.twig', [
            'form' => $form->createView(),
            'request' => $request,
            'errors' => $errors,
        ]);
    }


    /**
     * @Route("/account/create", name="account_create")
     */
    public function create(Request $request, StrategyClient $strategy, \App\Utils\ActionLogger $logger)
    {

        $form = $this->createFormBuilder()
            ->add('account', TextType::class, ['label' => 'Account Name', 'attr' => ['display' => 'block']])
            ->add('password', PasswordType::class, ['label' => 'Password'])
            ->add('repeatPassword', PasswordType::class, ['label' => 'Repeat Password'])
            ->add('email', TextType::class, ['label' => 'E-mail'])
            ->add('repeatEmail', TextType::class, ['label' => 'Repeat E-mail'])
            ->add('Create', SubmitType::class, ['label' => 'Create Account'])
            ->getForm();

        $form->handleRequest($request);

        $errors = [];
        if ( $form->isSubmitted() && $form->isValid() )
        {
            $formData = $form->getData();

            // Checking for errors
            if ( $strategy->getAccounts()->getAccountBy(['name' => $formData['account']]) !== null )
                $errors[] = "Account Name taken";
            if ( $formData['password'] != $formData['repeatPassword'] )
                $errors[] = "Passwords don't match";
            if ( $formData['email'] != $formData['repeatEmail'] )
                $errors[] = "E-mails don't match";
            if ( strlen($formData['account']) > 20 || strlen($formData['account']) < 6 )
                $errors[] = "Account Name must contain at least 6 characters and must be shorter than 20 characters";
            if ( strlen($formData['password']) > 20 || strlen($formData['password']) < 6 )
                $errors[] = "Password must contain at least 6 characters and must be shorter than 20 characters";


            // No errors found
            if ( empty($errors) )
            {
                $strategy->getAccounts()->createAccount($formData);


                //LOG ACTION
                $logger->setAction(1); // action 1 = created account
                $logger->save();


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
    public function createCharacter(Request $request, SessionInterface $session, StrategyClient $strategy, \App\Utils\ActionLogger $logger)
    {
        // this variable defines how big level is on start

        /**
         * [TODO] get vocations, gains of cap and health/mana from vocation.xml
         */


        if ( $session->get('account_id') !== null )
        {
            $form = $this->createFormBuilder()
                ->add('name', TextType::class, ['label' => 'Name', 'attr' => ['display' => 'block']])
                ->add('sex', ChoiceType::class, [
                    'label' => 'Sex',
                    'choices' => [
                        'Male' => 1,
                        'Female' => 0,
                    ],
                ])
                ->add('vocation', ChoiceType::class, [
                    'label' => 'Vocation',
                    'choices' => Configs::$config['player']['vocations'],
                ])
                ->add('city', ChoiceType::class, [
                    'label' => 'City',
                    'choices' => Configs::$config['player']['cities'],
                ])
                ->add('Create', SubmitType::class, ['label' => 'Create'])
                ->getForm();

            $form->handleRequest($request);

            $errors = [];
            if ( $form->isSubmitted() && $form->isValid() )
            {
                $formData = $form->getData();


                // Checking for errors
                if ( $strategy->getAccounts()->isPlayerName($formData['name']) )
                    $errors[] = "Name taken";
                if ( strlen($formData['name']) > 25 )
                    $errors[] = "Name longer than 20 char";
                if ( preg_match("/^([A-Za-z] ?)*([A-Za-z])+$/", $formData['name']) === 0 )
                    $errors[] = "Name can only contain letters from [A-Z][a-z] and spaces";

                $patterns = ['^gm', '^god', '^tutor', 'admin', 'kurwa', '^cm'];
                $regex = '/(' . implode('|', $patterns) . ')/i';
                if ( preg_match($regex, $formData['name']) === 1 )
                    $errors[] = "Name contains illegal string";

                // No errors found
                if ( empty($errors) )
                {

                    $strategy->getAccounts()->createCharacter($formData, $session->get('account_id'), Configs::$config['player']);

                    //LOG ACTION
                    $logger->setAction(3); // action 3 = create char
                    $logger->save();

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
        } else
        {
            return $this->redirectToRoute('account_login');
        }
    }


    /**
     * @Route("/account/delete/character/{playerId}", name="account_delete_character", requirements={"playerId"="\d+"})
     */
    public function deleteCharacter(int $playerId, Request $request, SessionInterface $session, StrategyClient $strategy, \App\Utils\ActionLogger $logger)
    {

        $error = [];
        if ( $session->get('account_id') == null )
        {
            $error[] = "You are not logged in";
            return $this->redirectToRoute('account_login');
        }


        $player = $strategy->getPlayers()->getPlayerBy(['id' => $playerId]);

        if ( $player->getAccount()->getId() != $session->get('account_id') )
        {
            $error[] = "Account do not match to character";
            return $this->redirectToRoute('account_login');
        }

        if ( empty($errors) )
        {
            $em = $this->getDoctrine()->getManager();
            $em->remove($player);
            $em->flush();


            //LOG ACTION
            $logger->setAction(4); // action 4 = delete char
            $logger->save();

            return $this->redirectToRoute('account');
        }
    }


    /**
     * @Route("/account/create/guild", name="account_create_guild")
     */
    public function createGuild(Request $request, SessionInterface $session, StrategyClient $strategy)
    {


        if ( $session->get('account_id') !== null )
        {
            // fetch all account chars
            $chars = $strategy->getAccounts()->getNoGuildPlayers($session->get('account_id'));


            $form = $this->createFormBuilder()
                ->add('name', TextType::class, ['label' => 'Guild Name', 'attr' => ['display' => 'block']])
                ->add('leader', ChoiceType::class, [
                    'label' => 'Leader',
                    'choices' => $chars,
                ])
                ->add('Create', SubmitType::class, ['label' => 'Create'])
                ->getForm();

            $form->handleRequest($request);

            $errors = [];
            if ( $form->isSubmitted() && $form->isValid() )
            {
                $formData = $form->getData();

                // Checking for errors
                if ( $strategy->getGuilds()->getGuildBy(['name' => $formData['name']]) !== null )
                    $errors[] = "Guild name taken";
                if ( $strategy->getPlayers()->getPlayerBy(['id' => $formData['leader'], 'account' => $session->get('account_id')]) == null )
                    $errors[] = "This character don't belong to you";
                if ( strlen($formData['name']) > 20 )
                    $errors[] = "Guild name longer than 20 char";
                if ( preg_match("/^([A-Za-z] ?)*([A-Za-z])+$/", $formData['name']) === 0 )
                    $errors[] = "Guild name can only contain letters from [A-Z][a-z] and spaces";

                $patterns = ['^gm', '^god', '^tutor', 'admin', 'kurwa', '^cm'];
                $regex = '/(' . implode('|', $patterns) . ')/i';
                if ( preg_match($regex, $formData['name']) === 1 )
                    $errors[] = "Guild name contains illegal string";
                // No errors found
                if ( empty($errors) )
                {
                    $guild = $strategy->getGuilds()->createGuild($formData['name'], $formData['leader']);

                    return $this->redirectToRoute('guild_management', ['id' => $guild]);
                }

            }
            return $this->render('account/account_create_guild.html.twig', [
                'form' => $form->createView(),
                'request' => $request,
                'errors' => $errors,
            ]);
        } else
        {
            return $this->redirectToRoute('account_login');
        }

    }


    /**
     * @Route("/account/change/password", name="account_change_password")
     */
    public function changePassword(Request $request, SessionInterface $session, StrategyClient $strategy, \App\Utils\ActionLogger $logger)
    {
        $action = 'Password';
        if ( $session->get('account_id') !== null )
        {

            $form = $this->createFormBuilder()
                ->add('currentPassword', TextType::class, ['label' => 'Current Password'])
                ->add('password', TextType::class, ['label' => 'Password'])
                ->add('repeatPassword', TextType::class, ['label' => 'Repeat Password'])
                ->add('Create', SubmitType::class, ['label' => 'Change'])
                ->getForm();

            $form->handleRequest($request);

            $errors = [];
            if ( $form->isSubmitted() && $form->isValid() )
            {
                $formData = $form->getData();

                // Checking for errors
                if ( $strategy->getAccounts()->getAccountBy(['id' => $session->get('account_id'), 'password' => $formData['password']]) !== null )
                    $errors[] = "Password incorrect";
                if ( $formData['password'] != $formData['repeatPassword'] )
                    $errors[] = "Passwords don't match";

                // No errors found
                if ( empty($errors) )
                {

                    $strategy->getAccounts()->changeAccountDetails($session->get('account_id'), ['password' => $formData['password']]);

                    //LOG ACTION
                    $logger->setAction(6); // action 6 = account changes
                    $logger->save();

                    return $this->redirectToRoute('account');
                }
            }
            return $this->render('account/account_change.html.twig', [
                'form' => $form->createView(),
                'request' => $request,
                'action' => $action,
                'errors' => $errors,
            ]);
        } else
        {
            return $this->redirectToRoute('account_login');
        }
    }


    /**
     * @Route("/account/change/email", name="account_change_email")
     */
    public function changeEmail(Request $request, SessionInterface $session, StrategyClient $strategy, ActionLogger $logger)
    {
        $action = 'Email';
        if ( $session->get('account_id') !== null )
        {

            $form = $this->createFormBuilder()
                ->add('email', TextType::class, ['label' => 'New Email'])
                ->add('repeatEmail', TextType::class, ['label' => 'Repeat Email'])
                ->add('password', TextType::class, ['label' => 'Password'])
                ->add('Create', SubmitType::class, ['label' => 'Change'])
                ->getForm();//TODO dodac klasy z formami

            $form->handleRequest($request);

            $errors = [];
            if ( $form->isSubmitted() && $form->isValid() )
            {
                $formData = $form->getData();

                // Checking for errors
                if ( $strategy->getAccounts()->getAccountBy(['id' => $session->get('account_id'), 'password' => $formData['password']]) == null )
                    $errors[] = "Password incorrect";
                if ( $formData['email'] != $formData['repeatEmail'] )
                    $errors[] = "Emails don't match";

                // No errors found
                if ( empty($errors) )
                {

                    $strategy->getAccounts()->changeAccountDetails($session->get('account_id'), ['email' => $formData['email']]);

                    //LOG ACTION
                    $logger->setAction(6); // action 6 = account changes
                    $logger->save();

                    return $this->redirectToRoute('account');
                }
            }
            return $this->render('account/account_change.html.twig', [
                'form' => $form->createView(),
                'request' => $request,
                'action' => $action,
                'errors' => $errors,
            ]);
        } else
        {
            return $this->redirectToRoute('account_login');
        }
    }

}
