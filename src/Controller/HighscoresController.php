<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Players;
use App\Entity\PlayerSkill;
use App\Entity\PlayerKiller;
use App\Entity\PlayerDeaths;
use Doctrine\ORM\Query\ResultSetMapping;

class HighscoresController extends Controller
{
    /**
     * @Route("/highscores/{filter}/{page}", name="highscores_level", requirements={
     *      "page"="\d+",
     *      "filter"="level|mlvl|fist|club|sword|axe|distance|shielding|fishing"
     * })
     */
    public function highscores($filter = "level", $page = 1, SessionInterface $session)
    {
        $resultsLimit = 15;
        
        //----LEVEL AND MLVL
        if ($filter === "level"){
            $result = $this->getDoctrine()
                ->getRepository(Players::class)
            ->findBy([
                'groupId' => 1,
            ],[
                'level' => "DESC"
            ], $resultsLimit ,$resultsLimit*($page-1));

            $filterName = "Level";
        }

        elseif ($filter === "mlvl"){
            $result = $this->getDoctrine()
                ->getRepository(Players::class)
            ->findBy([
                'groupId' => 1,
            ],[
                'maglevel' => "DESC"
            ], $resultsLimit ,$resultsLimit*($page-1));

            // if (count($result) == 0){
            //     $qb = $this->getDoctrine()->getEntityManager()->createQueryBuilder();
            //     $qb->select('count(player.id)');
            //     $qb->from('App:Players','player');
            //     $count = $qb->getQuery()->getSingleScalarResult();
            //     //var_dump($count);
            //     //echo $redirPage = ceil((int)$count/$resultsLimit.0);
            //     return $this->redirectToRoute('highscores_level', ['page' => $redirPage]);
            // }

            $filterName = "Magic Level";
        }
        //----SKILLS
        elseif ($filter === "fist"){
            $result = $this->getDoctrine()
                ->getRepository(PlayerSkill::class)
            ->findBy([
                'skillid' => 0,
            ],[
                'value' => "DESC"
            ], $resultsLimit ,$resultsLimit*($page-1));

            $filterName = "Fist Fighting";
        }

        elseif ($filter === "club"){
            $result = $this->getDoctrine()
                ->getRepository(PlayerSkill::class)
            ->findBy([
                'skillid' => 1,
            ],[
                'value' => "DESC"
            ], $resultsLimit ,$resultsLimit*($page-1));

            $filterName = "Club Fighting";
        }

        elseif ($filter === "sword"){
            $result = $this->getDoctrine()
                ->getRepository(PlayerSkill::class)
            ->findBy([
                'skillid' => 2,
            ],[
                'value' => "DESC"
            ], $resultsLimit ,$resultsLimit*($page-1));

            $filterName = "Sword Fighting";
        }

        elseif ($filter === "axe"){
            $result = $this->getDoctrine()
                ->getRepository(PlayerSkill::class)
            ->findBy([
                'skillid' => 3,
            ],[
                'value' => "DESC"
            ], $resultsLimit ,$resultsLimit*($page-1));

            $filterName = "Axe Fighting";
        }

        elseif ($filter === "distance"){
            $result = $this->getDoctrine()
                ->getRepository(PlayerSkill::class)
            ->findBy([
                'skillid' => 4,
            ],[
                'value' => "DESC"
            ], $resultsLimit ,$resultsLimit*($page-1));

            $filterName = "Distance Fighting";
        }

        elseif ($filter === "shielding"){
            $result = $this->getDoctrine()
                ->getRepository(PlayerSkill::class)
            ->findBy([
                'skillid' => 5,
            ],[
                'value' => "DESC"
            ], $resultsLimit ,$resultsLimit*($page-1));

            $filterName = "Shielding";
        }

        elseif ($filter === "fishing"){
            $result = $this->getDoctrine()
                ->getRepository(PlayerSkill::class)
            ->findBy([
                'skillid' => 6,
            ],[
                'value' => "DESC"
            ], $resultsLimit ,$resultsLimit*($page-1));

            $filterName = "Fishing";
        }
        // if page has no results redirect to last page
        if (count($result) == 0){
            $qb = $this->getDoctrine()->getEntityManager()->createQueryBuilder();
            $qb->select('count(player.id)');
            $qb->from('App:Players','player');
            $count = $qb->getQuery()->getSingleScalarResult();
            //var_dump($count);
            $redirPage = ceil((int)$count/(float)$resultsLimit);
            return $this->redirectToRoute('highscores_level', ['page' => $redirPage, 'filter' => $filter]);
        }

        return $this->render('highscores/index.html.twig', [
            'controller_name' => 'HighscoresController',
            'players' => $result,
            'page' => $page,
            'filter' => $filter,
            'filterName' => $filterName,
            'resultsLimit' => $resultsLimit,
        ]);
    }



}
