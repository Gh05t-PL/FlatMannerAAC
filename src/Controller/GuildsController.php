<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

use App\Utils\Configs;

use App\Utils\Strategy\StrategyClient;

use Doctrine\ORM\Query\ResultSetMapping;

class GuildsController extends Controller
{
    /**
     * @Route("/guilds", name="guilds")
     */
    public function index()
    {

        $strategy = new StrategyClient($this->getDoctrine());
        $guilds = $strategy->guilds->getGuildsList();


        return $this->render('guilds/index.html.twig', [
            'guilds' => $guilds,
        ]);
    }


    /**
     * @Route("/guilds/{id}", name="guild_management", requirements={"id"="\d+"})
     */
    public function guild($id, SessionInterface $session)
    {
        $strategy = new StrategyClient($this->getDoctrine());
        
        // fetch guild entity
        $guild = $strategy->guilds->getGuildById($id);
        if ( $guild === null )
            return $this->redirectToRoute('guilds');
        // get members
        $members = $strategy->guilds->getGuildMembers($id);
        //var_dump($members);

        // get invitations
        $invitations = $strategy->guilds->getGuildInvites($id);


        // check max rank of members tide to logged in account
        $loggedRankLevel = $strategy->guilds->getAccountGuildRank($session->get('account_id'), $members);
        
        

        return $this->render('guilds/guild.html.twig', [
            'guild' => $guild,
            'members' => $members,
            'invitations' => $invitations,
            'accountId' => $session->get('account_id'),
            'loggedRankLevel' => $loggedRankLevel,
        ]);

    }


    /**
     * @Route("/guilds/{id}/invitation/{playerId}", name="guild_accept_invite", requirements={"id"="\d+","playerId"="\d+"})
     */
    public function guildAcceptInvite($id, $playerId, SessionInterface $session)
    {
        $strategy = new StrategyClient($this->getDoctrine());


        $error = [];
        // CHECK IF LOGGED IN
        if ( $session->get('account_id') == NULL ){
            $error[] = "You are not logged in";
            return $this->redirectToRoute('guild_management', ['id' => $id]);
        }

        // CHECK IF ACCOUNT CONTAIN THIS CHAR
        $player = $strategy->players->getPlayerBy(['id' => $playerId]);
        if ( $player->getAccount()->getId() != $session->get('account_id') ){
            $error[] = "Account do not match to character";
            return $this->redirectToRoute('guild_management', ['id' => $id]);
        }  

        // CHECK IF PLAYER IS INVITED
        $rsm = new ResultSetMapping;
        $rsm->addScalarResult('player_id', 'player_id');
        $rsm->addScalarResult('guild_id', 'guild_id');
        $invitation = $this->getDoctrine()->getManager()
            ->createNativeQuery("SELECT player_id, guild_id FROM guild_invites WHERE player_id = $playerId AND guild_id = $id", $rsm)
        ->getArrayResult();

        if ( empty($invitation) == true ){
            $error[] = "You are not invited";
            return $this->redirectToRoute('guild_management', ['id' => $id]);
        }

        // CHECK IF PLAYER IS MEMBER IN ANY GUILD
        $isMemberAny = $strategy->guilds->isMember($playerId);
        if ( $isMemberAny )
        {
            $error[] = "You must leave your guild first";
            return $this->redirectToRoute('guild_management', ['id' => $id]);
        }

        // FIND MEMBER RANK_ID
        $rsm = new ResultSetMapping;
        $rsm->addScalarResult('id', 'id');

        $rankId = $this->getDoctrine()->getManager()
            ->createNativeQuery("SELECT MIN(id) as id FROM `guild_ranks` WHERE `guild_id` = $id AND level = 1", $rsm)
        ->getSingleScalarResult();
        
        // $player->setRankId($rankId);

        $data = [
            'rankId' => $rankId,
            'guildId' => $id,
            'playerId' => $playerId
        ];

        $strategy->guilds->acceptInvite($data);

        $em = $this->getDoctrine()->getManager();
        // $em->persist($player);
        // $em->flush();

        $sql = "DELETE FROM guild_invites WHERE player_id = $playerId AND guild_id = $id";
        $stmt = $em->getConnection()->prepare($sql);
        $stmt->execute();

        return $this->redirectToRoute('guild_management', ['id' => $id]);
    }


    /**
     * @Route("/guilds/{id}/ranks/managment", name="guild_ranks_managment", requirements={"id"="\d+"})
     */
    public function guildRanksManagment($id, SessionInterface $session, Request $request)
    {
        $strategy = new StrategyClient($this->getDoctrine());

        $guild = $strategy->guilds->getGuildById($id);
        // get rank level for logged in account
        $members = $strategy->guilds->getGuildMembers($id);

        $access = $strategy->guilds->getAccountGuildRank($session->get('account_id'), $members);
        
        if ( $access < 2 )
            return $this->redirectToRoute('guild_management', ['id' => $id]);
        

        $ranksTemp = $strategy->guilds->getGuildRanks($id);

        $ranks = [];
        foreach ($ranksTemp as $key => $value) {
            $ranks[$value->getName()] = $value->getId();
        }

        //$ranksTemp = null;
        // create form
        $form = $this->createFormBuilder()
            ->add('rankId', ChoiceType::class, [
                'label' => 'Rank',
                'choices' => $ranks,
                
            ])
            ->add('newName', TextType::class, array(
                'label' => 'New Name',
                'required' => false,
            ))
            ->add('newAccess', TextType::class, array(
                'label' => 'New Access',
                'required' => false,
            ))
            ->add('Submit', SubmitType::class, array('label' => 'Submit'))
        ->getForm();

        //REQUEST FORM
        $form->handleRequest($request);
        $errors =[];
        if ( $form->isSubmitted() && $form->isValid() ) 
        {
            $formData = $form->getData();
            $rank;
            foreach ($ranksTemp as $key => $value) {
                if ( (int)$value->getId() === (int)$formData['rankId'] )
                {
                    $rank = $value;
                }
            }

            // CHECKING FOR ERRORS
            if ( $formData['newAccess'] !== null && $rank->getLevel() > $access )
                $errors[] = "Sorry you can't edit higher rank then yours";
            if ( \preg_match("([A-Za-z ]+)",$formData['newName']) == 0 )
                $errors[] = "Rank name must contain characters [a-zA-Z ] only";
            if ( $formData['newAccess'] !== null && $formData['newAccess'] > $access )
                $errors[] = "Sorry you can't set higher access then yours";
            if ( $formData['newAccess'] !== null && !((int)$formData['newAccess'] <= 3 && (int)$formData['newAccess'] > 0) )
                $errors[] = "Access must be in range from 1 to 3";


            if ( empty($errors) )
            {
                if ( !empty($formData['newName']) )
                    $rank->setName($formData['newName']);

                if ( !empty($formData['newAccess']) )
                    $rank->setLevel((int)$formData['newAccess']);

                $em = $this->getDoctrine()->getManager();
                $em->persist($rank);
                $em->flush();

                return $this->redirectToRoute('guild_management', ['id' => $id]);
            }
            

        }


        return $this->render('guilds/guild_ranks_managment.html.twig', [
            'guild' => $guild,
            'form' => $form->createView(),
            'errors' => $errors,
        ]);
    }

    
    /**
     * @Route("/guilds/{id}/invitation/add", name="guild_invitation_add", requirements={"id"="\d+"})
     */
    public function guildInvitationAdd($id, SessionInterface $session, Request $request)
    {
        $strategy = new StrategyClient($this->getDoctrine());
        
        // fetch guild entity
        $guild = $strategy->guilds->getGuildById($id);


        // get rank level for logged in account
        $members = $strategy->guilds->getGuildMembers($id);

        $access = $strategy->guilds->getAccountGuildRank($session->get('account_id'), $members);
        
        if ( $access < 2 )
            return $this->redirectToRoute('guild_management', ['id' => $id]);
        
        // create form
        $form = $this->createFormBuilder()
            ->add('nick', TextType::class, array('label' => 'Player Name'))
            ->add('Invite', SubmitType::class, array('label' => 'Submit'))
        ->getForm();

        //REQUEST FORM
        $form->handleRequest($request);
        $errors =[];
        if ( $form->isSubmitted() && $form->isValid() ) {
            $formData = $form->getData();

            // Checking for errors
            if ( $strategy->players->getPlayerBy(['name' => $formData['nick']]) == NULL ){
                $errors[] = "Player \"{$formData['nick']}\" do not exist";
                return $this->render('guilds/guild_invitation_add.html.twig', [
                    'guild' => $guild,
                    'form' => $form->createView(),
                    'errors' => $errors,
                ]);
            }

            
            $player = $strategy->players->getPlayerBy(['name' => $formData['nick']]);
            $rsm = new ResultSetMapping;
            $rsm->addScalarResult('player_id', 'player_id');
            $rsm->addScalarResult('guild_id', 'guild_id');

            // check if invitation is not sent again
            $invitation = $this->getDoctrine()->getManager()
                ->createNativeQuery("SELECT player_id, guild_id FROM guild_invites WHERE player_id = {$player->getId()} AND guild_id = $id", $rsm)
            ->getArrayResult();
            if ( !empty($invitation) )
                $errors[] = "Player \"{$formData['nick']}\" is already invited";


            
            // check if invitation is not sent to member
            $isMember = false;
            foreach ($members as $key => $value) {
                if ( strtolower($value['nick']) == strtolower($formData['nick']) )
                    $isMember = true;
                    break;
            }
                
            if ( $isMember )
                $errors[] = "Player \"{$formData['nick']}\" is member already";


            
            if ( empty($errors) ) {
                $em = $this->getDoctrine()->getManager();
                $sql = "INSERT INTO guild_invites VALUES ({$player->getId()}, {$guild->getId()})";
                $stmt = $em->getConnection()->prepare($sql);
                $stmt->execute();
                return $this->redirectToRoute('guild_management', ['id' => $id]);
            }

        }
        
        return $this->render('guilds/guild_invitation_add.html.twig', [
            'guild' => $guild,
            'form' => $form->createView(),
            'errors' => $errors,
        ]);
    }


    /**
     * @Route("/guilds/{id}/leave/{playerId}", name="guild_leave", requirements={"id"="\d+","playerId"="\d+"})
     */
    public function guildLeave($id, $playerId, SessionInterface $session, Request $request)
    {
        $strategy = new StrategyClient($this->getDoctrine());

        $error = [];
        if ( $session->get('account_id') == NULL ){
            $error[] = "You are not logged in";
            return $this->redirectToRoute('guild_management', ['id' => $id]);
        }


        $player = $strategy->players->getPlayerBy(['id' => $playerId]);

        if ( $player->getAccount()->getId() != $session->get('account_id') ){
            $error[] = "Account do not match to character";
            return $this->redirectToRoute('guild_management', ['id' => $id]);
        }  

        if (empty($errors)) {
            $em = $this->getDoctrine()->getManager();

            // get rank level for logged in account
            $members = $strategy->guilds->getGuildMembers($id);

            foreach ($members as $key => $value) {
                if ( $value['id'] == $playerId)
                    $access = $value['rankLevel'];
            }

            if ( $access == 3 ){
                $guild = $strategy->guilds->getGuildById($id);

                $em->remove($guild);
                $em->flush();
                return $this->redirectToRoute('guilds');
            }else{

                $strategy->guilds->leaveGuild($playerId);

                return $this->redirectToRoute('guild_management', ['id' => $id]);
            }
        }
    }


    /**
     * @Route("/guilds/{id}/delete", name="guild_delete", requirements={"id"="\d+"})
     */
    public function guildDelete($id, SessionInterface $session, Request $request)
    {
        $strategy = new StrategyClient($this->getDoctrine());
        $error = [];
        if ( $session->get('account_id') == NULL ){
            $error[] = "You are not logged in";
            return $this->redirectToRoute('guild_management', ['id' => $id]);
        }

        if ( $strategy->guilds->getGuildById($id) == null ){
            $error[] = "Guild don't exists";
            return $this->redirectToRoute('guilds');
        }

        // get rank level for logged in account
        $members = $strategy->guilds->getGuildMembers($id);

        $access = $strategy->guilds->getAccountGuildRank($session->get('account_id'), $members);

        if ( $access != 3 ){
            $error[] = "You are not leader";
            return $this->redirectToRoute('guild_management', ['id' => $id]);
        }

        if (empty($errors)) {

            $guild = $strategy->guilds->getGuildById($id);

            $em = $this->getDoctrine()->getManager();
            $em->remove($guild);
            $em->flush();
            return $this->redirectToRoute('guilds');
        }

    }






}
