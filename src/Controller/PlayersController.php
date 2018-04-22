<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Players;
use App\Entity\PlayerSkill;
use App\Entity\PlayerKiller;
use App\Entity\PlayerDeaths;
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
        //, requirements={"page"="\d+"}

        $result = $this->getDoctrine()
            ->getRepository(Players::class)
        ->findOneBy([
            'name' => $name,
        ]);
        
        if ($result !== NULL){
            //Player Skills
            $playerSkills = $this->getDoctrine()
            ->getRepository(PlayerSkill::class)
            ->findBy([
                'player' => $result->getId(),
            ]);
            //Player Kills
            $playerPK = $this->getDoctrine()
            ->getRepository(PlayerKiller::class)
            ->findBy([
                'killer' => $result->getId(),
            ]);

            //Deaths by Player
            $rsm = new ResultSetMapping;
            $rsm->addEntityResult('App:Players', 'p');
            $rsm->addFieldResult('p', 'id', 'id');
            $rsm->addFieldResult('p', 'name', 'name');
            $rsm->addScalarResult('level', 'level');
            $rsm->addScalarResult('date', 'date');

            //WHY getResult returns 1 element?
            //SELECT name,level,`date` from players WHERE id = t2.player_id (SELECT t2.player_id,level,`date` FROM (SELECT id,level,`date` FROM player_deaths WHERE player_id = {$result->getId()}) t1 INNER JOIN (SELECT kill_id, player_id FROM player_killers) t2 on t1.id = t2.kill_id
            $playerKillers = $this->getDoctrine()->getEntityManager()
                ->createNativeQuery("SELECT id,name,t4.level,`date` FROM players t3 INNER JOIN (SELECT t2.player_id,level,`date` FROM (SELECT id,level,`date` FROM player_deaths WHERE player_id = {$result->getId()}) t1 INNER JOIN (SELECT kill_id, player_id FROM player_killers) t2 on t1.id = t2.kill_id) t4 on t3.id = t4.player_id", $rsm)
            ->getArrayResult();
                var_dump($playerKillers);
            //Deaths by Monsters
            $rsm = new ResultSetMapping;
            $rsm->addScalarResult('name', 'name');
            $rsm->addScalarResult('level', 'level');
            $rsm->addScalarResult('date', 'date');

            $monsterKillers = $this->getDoctrine()->getEntityManager()
                ->createNativeQuery("SELECT name,level,date FROM (SELECT id,level,date FROM player_deaths WHERE player_id = {$result->getId()}) t1 INNER JOIN (SELECT kill_id, name FROM environment_killers) t2 on t1.id = t2.kill_id", $rsm)
            ->getResult();

        }
            

        return $this->render('players/player.html.twig', [
            'controller_name' => 'PlayersController',
            'player' => @$result,
            'playerSkills' => @$playerSkills,
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
        $onlines = $this->getDoctrine()
            ->getRepository(Players::class)
        ->findBy([
            'online' => 1,
        ]);

        return $this->render('players/online.html.twig', [
            'controller_name' => 'PlayersController',
            'onlines' => @$onlines,
        ]);
    }
}
