<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Players;
use App\Entity\Accounts;

use Doctrine\ORM\Query\ResultSetMapping;

class PlayersController extends Controller
{
    /**
     * @Route("/player", name="player_search")
     */
    public function playerSearch()
    {
        return $this->render('players/search.html.twig', [
            'controller_name' => 'PlayersController',
        ]);
    }


    /**
     * @Route("/player/{name}", name="player")
     */
    public function player($name)
    {
        

        $result = $this->getDoctrine()
            ->getRepository(Players::class)
        ->findOneBy([
            'name' => $name,
        ]);
        
        if ($result !== NULL){
            
            // Player Kills
            $rsm = new ResultSetMapping;
            $rsm->addScalarResult('count(*)', 'count');

            $playerKillsCount = $this->getDoctrine()->getManager()
                ->createNativeQuery("SELECT count(*) FROM `player_deaths` WHERE `killed_by` in (select name from players where id = {$result->getId()}) AND is_player = 1", $rsm)
            ->getSingleScalarResult();
            $result->kills = $playerKillsCount;

            $rsm = new ResultSetMapping;
            $rsm->addScalarResult('id', 'id');
            $rsm->addScalarResult('fragName', 'name');
            $rsm->addScalarResult('date', 'time');
            $rsm->addScalarResult('fragLevel', 'level');
            $rsm->addScalarResult('unjustified', 'unjustified');

            $playerPK = $this->getDoctrine()->getManager()
                ->createNativeQuery("SELECT id, t1.name as fragName, t2.time as date, t2.level as fragLevel, t2.unjustified FROM players t1 INNER JOIN (SELECT * FROM `player_deaths` WHERE `killed_by` in (select name from players where id = {$result->getId()}) AND is_player = 1) t2 ON t1.id = t2.player_id", $rsm)
            ->getResult();
            

            // ONLINE
            $rsm = new ResultSetMapping;
            $rsm->addScalarResult('player_id', 'id');

            $playerOnline = $this->getDoctrine()->getManager()
                ->createNativeQuery("SELECT * FROM players_online WHERE player_id = {$result->getId()}", $rsm)
            ->getResult();
            if ( empty($playerOnline) )
                $result->online = false;
            else
                $result->online = true;

            // Deaths by Player
            $rsm = new ResultSetMapping;
            $rsm->addScalarResult('time', 'date');
            $rsm->addScalarResult('level', 'level');
            $rsm->addScalarResult('killed_by', 'name');
            $rsm->addScalarResult('unjustified', 'unjustified');  

            $playerKillers = $this->getDoctrine()->getManager()
                ->createNativeQuery("SELECT time,level,killed_by,unjustified FROM `player_deaths` WHERE `player_id` = {$result->getId()} AND is_player = 1", $rsm)
            ->getArrayResult();
            
            // Deaths by Monsters
            $rsm = new ResultSetMapping;
            $rsm->addScalarResult('time', 'date');
            $rsm->addScalarResult('level', 'level');
            $rsm->addScalarResult('killed_by', 'name');
            $rsm->addScalarResult('unjustified', 'unjustified');  

            $monsterKillers = $this->getDoctrine()->getManager()
                ->createNativeQuery("SELECT time,level,killed_by,unjustified FROM `player_deaths` WHERE `player_id` = {$result->getId()} AND is_player = 0", $rsm)
            ->getResult();


            // EXP DIFF
            $rsm = new ResultSetMapping;
            $rsm->addScalarResult('expDiff', 'expDiff');

            $expDiff = $this->getDoctrine()->getManager()
                ->createNativeQuery("SELECT (t1.experience - expBefore) as expDiff FROM players t1 INNER JOIN (SELECT player_id, exp as expBefore FROM today_exp) t2 ON t1.id = t2.player_id where id = {$result->getId()}", $rsm)
            ->getSingleScalarResult();
            
            $result->expDiff = $expDiff;
            

        }
            

        return $this->render('players/player.html.twig', [
            'controller_name' => 'PlayersController',
            'player' => @$result,
            'playerPK' => @$playerPK,
            'playerKillers' => @$playerKillers,
            'monsterKillers' => @$monsterKillers,

        ]);
    }


    /**
     * @Route("/players/online", name="player_online")
     */
    public function playerOnline()
    {


        $rsm = new ResultSetMapping;
        $rsm->addScalarResult('name', 'name');
        $rsm->addScalarResult('level', 'level');
        $rsm->addScalarResult('vocation', 'vocation');

        $onlines = $this->getDoctrine()->getManager()
            ->createNativeQuery("SELECT name, level, vocation FROM players t1 INNER JOIN (SELECT * FROM `players_online` WHERE 1) t2 ON t1.id = t2.`player_id`", $rsm)
        ->getResult();


        return $this->render('players/online.html.twig', [
            'controller_name' => 'PlayersController',
            'onlines' => @$onlines,
        ]);
    }
}
