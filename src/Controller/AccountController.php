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

class AccountController extends Controller
{



    /**
     * @Route("/account", name="account")
     */
    public function account(SessionInterface $session){

        // if session['account_id'] !== NULL AND loginIp == CurrentIp then
        if ( $session->get('account_id') !== NULL ){
            // siemka jestem logniety, no zapraszam zapraszam zaraz dam ci info o twoim koncie
            echo 'Logged IN as ' . $session->get('account_id');

            // tu twoje oczekiwane info
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
            // no nie jestes zalogowany a to zle, przekierowuje 301 perm
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

        if ( $form->isSubmitted() && $form->isValid() ) {
            //echo $request;
            echo "<br>";

            $account = $this->getDoctrine()
                ->getRepository(Accounts::class)
            ->findOneBy([
                'name' => $form->getData()['Account'],
                'password' => $form->getData()['Password']
            ]);


            if ( $account !== NULL ){
                $session->set('account_id', $account->getId());
                echo "SETTED ".$account->getId();
            }
            return $this->redirectToRoute('account');
        }

        echo "accId: ".$session->get('account_id');
        return $this->render('account/account_login.html.twig', [
            'form' => $form->createView(),
            'request' => $request,
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

        $startLevel = 8;



        if ($session->get('account_id') !== NULL){
        $form = $this->createFormBuilder()
            ->add('name', TextType::class, ['label' => 'Name', 'attr' => ['display' => 'block']])
            ->add('sex', ChoiceType::class, [
                'label' => 'Sex',
                'choices' => [
                    'Male' => 1,
                    'Female' => 2
                ]
            ])
            ->add('vocation', ChoiceType::class, [
                'label' => 'Vocation',
                'choices' => [
                    'Sorcerer' => 1,
                    'Druid' => 2,
                    'Paladin' => 3,
                    'Knight' => 4
                ]
            ])
            ->add('Create', SubmitType::class, ['label' => 'Create'])
        ->getForm();

        $form->handleRequest($request);

        $errors = [];
        if ( $form->isSubmitted() && $form->isValid() ) {
            $formData = $form->getData();

            $player = new Players();

            $player->name = $formData['name'];
            $player->sex = $formData['sex'];
            $player->vocation = $formData['vocation'];
            $player->account = $this->getDoctrine()->getRepository(Accounts::class)->find($session->get('account_id'));
            $player->level = $startLevel;

            function expToLevel($level){
                return ((50 * ($level - 1)**3 - 150 * ($level - 1)**2 + 400 * ($level - 1)) / 3);
            }

            $player->exp = expToLevel($startLevel);

            $em = $this->getDoctrine()->getManager();
            $em->persist($player);
            $em->flush();
            return $this->redirectToRoute('account');
        }

        return $this->render('account/account_create_character.html.twig', [
            'form' => $form->createView(),
            'request' => $request,
            'errors' => $errors,
        ]);
        }else{
            return $this->redirectToRoute('account_login');
        }

    }

}
