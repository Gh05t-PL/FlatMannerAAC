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
                'player' => $result->id,
            ]);
            //Player Kills
            $playerPK = $this->getDoctrine()
            ->getRepository(PlayerKiller::class)
            ->findBy([
                'killer' => $result->id,
            ]);

            //Deaths by Player
            $rsm = new ResultSetMapping;
            $rsm->addEntityResult('App:Players', 'p');
            $rsm->addFieldResult('p', 'player_id', 'id');
            $rsm->addScalarResult('level', 'level');
            $rsm->addScalarResult('date', 'date');


            $playerKillers = $this->getDoctrine()->getEntityManager()
                ->createNativeQuery("SELECT player_id,level,`date` FROM (SELECT id,level,`date` FROM player_deaths WHERE player_id = 11) t1 INNER JOIN (SELECT kill_id, player_id FROM player_killers) t2 on t1.id = t2.kill_id", $rsm)
            ->getResult();

            //Deaths by Monsters
            $rsm = new ResultSetMapping;
            $rsm->addScalarResult('name', 'name');
            $rsm->addScalarResult('level', 'level');
            $rsm->addScalarResult('date', 'date');

            $monsterKillers = $this->getDoctrine()->getEntityManager()
                ->createNativeQuery("SELECT name,level,date FROM (SELECT id,level,date FROM player_deaths WHERE player_id = 11) t1 INNER JOIN (SELECT kill_id, name FROM environment_killers) t2 on t1.id = t2.kill_id", $rsm)
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
}
