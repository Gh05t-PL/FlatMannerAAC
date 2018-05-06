<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Players;
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

        // GET COUNT OF POSSIBLE RESULTS
        $possibleCount = count($this->getDoctrine()
        ->getRepository(Players::class)
        ->findBy([
            'groupId' => 1,
        ],[
            'maglevel' => "DESC"
        ]));

        // GET POSSIBLE COUNT OF PAGES
        $pagesCount = ceil(($possibleCount / $resultsLimit));
        
        
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


            $filterName = "Magic Level";
        }
        //----SKILLS
        elseif ($filter === "fist"){
            $result = $this->getDoctrine()
                ->getRepository(Players::class)
            ->findBy([
                'groupId' => 1,
            ],[
                'skillFist' => "DESC"
            ], $resultsLimit ,$resultsLimit*($page-1));

            $filterName = "Fist Fighting";
        }

        elseif ($filter === "club"){
            $result = $this->getDoctrine()
                ->getRepository(Players::class)
            ->findBy([
                'groupId' => 1,
            ],[
                'skillClub' => "DESC"
            ], $resultsLimit ,$resultsLimit*($page-1));

            $filterName = "Club Fighting";
        }

        elseif ($filter === "sword"){
            $result = $this->getDoctrine()
                ->getRepository(Players::class)
            ->findBy([
                'groupId' => 1,
            ],[
                'skillSword' => "DESC"
            ], $resultsLimit ,$resultsLimit*($page-1));

            $filterName = "Sword Fighting";
        }

        elseif ($filter === "axe"){
            $result = $this->getDoctrine()
                ->getRepository(Players::class)
            ->findBy([
                'groupId' => 1,
            ],[
                'skillAxe' => "DESC"
            ], $resultsLimit ,$resultsLimit*($page-1));

            $filterName = "Axe Fighting";
        }

        elseif ($filter === "distance"){
            $result = $this->getDoctrine()
                ->getRepository(Players::class)
            ->findBy([
                'groupId' => 1,
            ],[
                'skillDist' => "DESC"
            ], $resultsLimit ,$resultsLimit*($page-1));

            $filterName = "Distance Fighting";
        }

        elseif ($filter === "shielding"){
            $result = $this->getDoctrine()
                ->getRepository(Players::class)
            ->findBy([
                'groupId' => 1,
            ],[
                'skillShielding' => "DESC"
            ], $resultsLimit ,$resultsLimit*($page-1));

            $filterName = "Shielding";
        }

        elseif ($filter === "fishing"){
            $result = $this->getDoctrine()
                ->getRepository(Players::class)
            ->findBy([
                'groupId' => 1,
            ],[
                'skillFishing' => "DESC"
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
            'pagesCount' => $pagesCount,
        ]);
    }



}
