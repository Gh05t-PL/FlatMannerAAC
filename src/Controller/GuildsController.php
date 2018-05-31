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

use App\Entity\Guilds;
use App\Entity\Players;

use Doctrine\ORM\Query\ResultSetMapping;
class GuildsController extends Controller
{
    /**
     * @Route("/guilds", name="guilds")
     */
    public function index()
    {

        $rsm = new ResultSetMapping;
        $rsm->addScalarResult('id', 'id');
        $rsm->addScalarResult('name', 'name');
        $rsm->addScalarResult('motd', 'motd');
        $rsm->addScalarResult('members', 'members');

        $guilds = $this->getDoctrine()->getManager()
            ->createNativeQuery("SELECT id,name,motd,IFNULL(membersCount,0) as members FROM guilds t3 LEFT JOIN (SELECT count(*) as membersCount,guild_id FROM players t1 INNER JOIN (SELECT * FROM guild_ranks) t2 ON t1.rank_id = t2.id group by guild_id) t4 ON t3.id = t4.guild_id", $rsm)
        ->getArrayResult();
        
        // $guilds = $this->getDoctrine()
        //     ->getRepository(Guilds::class)
        // ->findBy(
        //     [],
        //     ['name' => 'ASC']
        // );

        return $this->render('guilds/index.html.twig', [
            'guilds' => $guilds,
        ]);
    }


    /**
     * @Route("/guilds/{id}", name="guild_management", requirements={"id"="\d+"})
     */
    public function guild($id, SessionInterface $session)
    {

        // fetch guild entity
        $guild = $this->getDoctrine()
            ->getRepository(Guilds::class)
        ->find($id);


        // sql get members
        $rsm = new ResultSetMapping;
        $rsm->addScalarResult('id', 'id');
        $rsm->addScalarResult('nick', 'nick');
        $rsm->addScalarResult('level', 'level');
        $rsm->addScalarResult('vocation', 'vocation');
        $rsm->addScalarResult('rank_id', 'rankId');
        $rsm->addScalarResult('guildnick', 'guildNick');
        $rsm->addScalarResult('rankName', 'rankName');
        $rsm->addScalarResult('rankLevel', 'rankLevel');
        $rsm->addScalarResult('account_id', 'accountId');

        $members = $this->getDoctrine()->getManager()
            ->createNativeQuery("SELECT t1.id as id, t1.name as nick, t1.level as level, vocation, rank_id, guildnick, account_id, t2.name as rankName, t2.level as rankLevel FROM players t1 INNER JOIN (SELECT * FROM guild_ranks WHERE guild_id = $id) t2 ON t1.rank_id = t2.id ORDER BY rankLevel DESC, level DESC", $rsm)
        ->getArrayResult();
        

        // sql get invitations
        $rsm = new ResultSetMapping;
        $rsm->addScalarResult('id', 'id');
        $rsm->addScalarResult('nick', 'nick');
        $rsm->addScalarResult('level', 'level');
        $rsm->addScalarResult('vocation', 'vocation');
        $rsm->addScalarResult('account_id', 'account_id');

        $invitations = $this->getDoctrine()->getManager()
            ->createNativeQuery("SELECT id, name as nick, level, vocation, account_id FROM players t1 INNER JOIN (SELECT * FROM guild_invites WHERE guild_id = $id ) t2 ON t1.id = t2.player_id ORDER BY level DESC", $rsm)
        ->getArrayResult();


        // check max rank of members tide to logged in account
        $isLeaderLogged = false;
        $loggedRankLevel = 0;
        foreach ($members as $value) {
            if ( $value['accountId'] == $session->get('account_id') && $value['rankLevel'] > $loggedRankLevel )
                $loggedRankLevel = $value['rankLevel'];
        }
        
        

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
        $error = [];
        if ( $session->get('account_id') == NULL ){
            $error[] = "You are not logged in";
            return $this->redirectToRoute('guild_management', ['id' => $id]);
        }


        $player = $this->getDoctrine()
            ->getRepository(\App\Entity\Players::class)
        ->find($playerId);

        if ( $player->getAccount()->getId() != $session->get('account_id') ){
            $error[] = "Account do not match to character";
            return $this->redirectToRoute('guild_management', ['id' => $id]);
        }  


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


            
        $rsm = new ResultSetMapping;
        $rsm->addScalarResult('id', 'id');

        $rankId = $this->getDoctrine()->getManager()
            ->createNativeQuery("SELECT MIN(id) as id FROM `guild_ranks` WHERE `guild_id` = $id AND level = 1", $rsm)
        ->getSingleScalarResult();
        
        $player->setRankId($rankId);
            
        $em = $this->getDoctrine()->getManager();
        $em->persist($player);
        $em->flush();

        $sql = "DELETE FROM guild_invites WHERE player_id = $playerId AND guild_id = $id";
        $stmt = $em->getConnection()->prepare($sql);
        $stmt->execute();

        return $this->redirectToRoute('guild_management', ['id' => $id]);
    }

    
    /**
     * @Route("/guilds/{id}/invitation/add", name="guild_invitation_add", requirements={"id"="\d+"})
     */
    public function guildInvitationAdd($id, SessionInterface $session, Request $request)
    {
        // fetch guild
        $guild = $this->getDoctrine()
            ->getRepository(Guilds::class)
        ->find($id);


        // fetch guild rank level max
        $rsm = new ResultSetMapping;
        $rsm->addScalarResult('access', 'access');

        $access = $this->getDoctrine()->getManager()
            ->createNativeQuery("SELECT IFNULL(MAX(level),1) as access FROM guild_ranks WHERE id IN (SELECT rank_id FROM players WHERE account_id = {$session->get('account_id')}) AND guild_id = {$id}", $rsm)
        ->getSingleScalarResult();
        
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
            if ( $this->getDoctrine()->getRepository(Players::class)->findOneBy(['name' => $formData['nick']]) == NULL ){
                $errors[] = "Player \"{$formData['nick']}\" do not exist";
                return $this->render('guilds/guild_invitation_add.html.twig', [
                    'guild' => $guild,
                    'form' => $form->createView(),
                    'errors' => $errors,
                ]);
            }

            
            $player = $this->getDoctrine()->getRepository(Players::class)->findOneBy(['name' => $formData['nick']]);
            $rsm = new ResultSetMapping;
            $rsm->addScalarResult('player_id', 'player_id');
            $rsm->addScalarResult('guild_id', 'guild_id');

            $invitation = $this->getDoctrine()->getManager()
                ->createNativeQuery("SELECT player_id, guild_id FROM guild_invites WHERE player_id = {$player->getId()} AND guild_id = $id", $rsm)
            ->getArrayResult();
            if ( !empty($invitation) )
                $errors[] = "Player \"{$formData['nick']}\" is already invited";


            $rsm = new ResultSetMapping;
            $rsm->addScalarResult('name', 'name');
            
            $isMember = empty($this->getDoctrine()->getManager()
                ->createNativeQuery("SELECT name FROM players WHERE rank_id IN (SELECT id FROM guild_ranks WHERE guild_id = {$id}) AND name = '{$player->getName()}'", $rsm)
            ->getArrayResult());
                
            if ( !$isMember )
                $errors[] = "Player \"{$formData['nick']}\" is member already";


            
            if (empty($errors)) {
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
        $error = [];
        if ( $session->get('account_id') == NULL ){
            $error[] = "You are not logged in";
            return $this->redirectToRoute('guild_management', ['id' => $id]);
        }


        $player = $this->getDoctrine()
            ->getRepository(\App\Entity\Players::class)
        ->find($playerId);

        if ( $player->getAccount()->getId() != $session->get('account_id') ){
            $error[] = "Account do not match to character";
            return $this->redirectToRoute('guild_management', ['id' => $id]);
        }  

        if (empty($errors)) {
            $player->setRankId(0);

            $em = $this->getDoctrine()->getManager();
            $em->persist($player);
            $em->flush();
            return $this->redirectToRoute('guild_management', ['id' => $id]);
            }
    }


    /**
     * @Route("/guilds/{id}/delete", name="guild_delete", requirements={"id"="\d+"})
     */
    public function guildDelete($id, SessionInterface $session, Request $request)
    {

        $error = [];
        if ( $session->get('account_id') == NULL ){
            $error[] = "You are not logged in";
            return $this->redirectToRoute('guild_management', ['id' => $id]);
        }

        if ( $this->getDoctrine()->getRepository(Guilds::class)->find($id) == null ){
            $error[] = "Guild don't exists";
            return $this->redirectToRoute('guilds');
        }

        // fetch guild rank level max
        $rsm = new ResultSetMapping;
        $rsm->addScalarResult('access', 'access');

        $access = $this->getDoctrine()->getManager()
            ->createNativeQuery("SELECT IFNULL(MAX(level),1) as access FROM guild_ranks WHERE id IN (SELECT rank_id FROM players WHERE account_id = {$session->get('account_id')}) AND guild_id = {$id}", $rsm)
        ->getSingleScalarResult();

        if ( $access != 3 ){
            $error[] = "You are not leader";
            return $this->redirectToRoute('guild_management', ['id' => $id]);
        }

        if (empty($errors)) {

            $guild = $this->getDoctrine()
                ->getRepository(Guilds::class)
            ->find($id);

            $em = $this->getDoctrine()->getManager();
            $em->remove($guild);
            $em->flush();
            return $this->redirectToRoute('guilds');
        }

    }






}
