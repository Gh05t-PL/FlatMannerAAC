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

        /*
        * Config
        */
        $resultsLimit = 15;
        $accessLimit = 3;


        // GET COUNT OF POSSIBLE RESULTS
        $possibleCount = $this->getDoctrine()
            ->getRepository(Players::class)
        ->findBy([],[
            'maglevel' => "DESC",
        ]);
            
        // unset element with group higher then 3
        foreach ($possibleCount as $key => $value) {
            if ( $value->getGroupId() > 3 )
                unset($possibleCount[$key]);
        }
        $possibleCount = count($possibleCount);

        // GET POSSIBLE COUNT OF PAGES
        $pagesCount = ceil(($possibleCount / $resultsLimit));
        
        
        //----LEVEL AND MLVL
        if ($filter === "level"){

            // $result = $this->getDoctrine()
            //     ->getRepository(Players::class)
            // ->findBy([
            //     'groupId' => 1,
            // ],[
            //     'level' => "DESC"
            // ], $resultsLimit ,$resultsLimit*($page-1));

            $query = $this->getDoctrine()->getEntityManager()->createQuery("SELECT p FROM App\Entity\Players p WHERE p.groupId <= {$accessLimit} ORDER BY p.level DESC, p.experience DESC, p.name ASC");
            $query->setMaxResults($resultsLimit)->setFirstResult($resultsLimit*($page-1));
 
            $result = $query->getResult();

            $filterName = "Level";
        }

        elseif ($filter === "mlvl"){

            // $result = $this->getDoctrine()
            //     ->getRepository(Players::class)
            // ->findBy([
            //     'groupId' => 1,
            // ],[
            //     'maglevel' => "DESC"
            // ], $resultsLimit ,$resultsLimit*($page-1));

            $query = $this->getDoctrine()->getEntityManager()->createQuery("SELECT p FROM App\Entity\Players p WHERE p.groupId <= {$accessLimit} ORDER BY p.maglevel DESC, p.manaspent DESC, p.name ASC");
            $query->setMaxResults($resultsLimit)->setFirstResult($resultsLimit*($page-1));
 
            $result = $query->getResult();


            $filterName = "Magic Level";
        }
        //----SKILLS
        elseif ($filter === "fist"){
            // $result = $this->getDoctrine()
            //     ->getRepository(Players::class)
            // ->findBy([
            //     'groupId' => 1,
            // ],[
            //     'skillFist' => "DESC"
            // ], $resultsLimit ,$resultsLimit*($page-1));

            $query = $this->getDoctrine()->getEntityManager()->createQuery("SELECT p FROM App\Entity\Players p WHERE p.groupId <= {$accessLimit} ORDER BY p.skillFist DESC, p.skillFistTries DESC, p.name ASC");
            $query->setMaxResults($resultsLimit)->setFirstResult($resultsLimit*($page-1));
 
            $result = $query->getResult();

            $filterName = "Fist Fighting";
        }

        elseif ($filter === "club"){
            // $result = $this->getDoctrine()
            //     ->getRepository(Players::class)
            // ->findBy([
            //     'groupId' => 1,
            // ],[
            //     'skillClub' => "DESC"
            // ], $resultsLimit ,$resultsLimit*($page-1));

            $query = $this->getDoctrine()->getEntityManager()->createQuery("SELECT p FROM App\Entity\Players p WHERE p.groupId <= {$accessLimit} ORDER BY p.skillClub DESC, p.skillClubTries DESC, p.name ASC");
            $query->setMaxResults($resultsLimit)->setFirstResult($resultsLimit*($page-1));
 
            $result = $query->getResult();

            $filterName = "Club Fighting";
        }

        elseif ($filter === "sword"){
            // $result = $this->getDoctrine()
            //     ->getRepository(Players::class)
            // ->findBy([
            //     'groupId' => 1,
            // ],[
            //     'skillSword' => "DESC"
            // ], $resultsLimit ,$resultsLimit*($page-1));

            $query = $this->getDoctrine()->getEntityManager()->createQuery("SELECT p FROM App\Entity\Players p WHERE p.groupId <= {$accessLimit} ORDER BY p.skillSword DESC, p.skillSwordTries DESC, p.name ASC");
            $query->setMaxResults($resultsLimit)->setFirstResult($resultsLimit*($page-1));
 
            $result = $query->getResult();

            $filterName = "Sword Fighting";
        }

        elseif ($filter === "axe"){
            // $result = $this->getDoctrine()
            //     ->getRepository(Players::class)
            // ->findBy([
            //     'groupId' => 1,
            // ],[
            //     'skillAxe' => "DESC"
            // ], $resultsLimit ,$resultsLimit*($page-1));

            $query = $this->getDoctrine()->getEntityManager()->createQuery("SELECT p FROM App\Entity\Players p WHERE p.groupId <= {$accessLimit} ORDER BY p.skillAxe DESC, p.skillAxeTries DESC, p.name ASC");
            $query->setMaxResults($resultsLimit)->setFirstResult($resultsLimit*($page-1));
 
            $result = $query->getResult();

            $filterName = "Axe Fighting";
        }

        elseif ($filter === "distance"){
            // $result = $this->getDoctrine()
            //     ->getRepository(Players::class)
            // ->findBy([
            //     'groupId' => 1,
            // ],[
            //     'skillDist' => "DESC"
            // ], $resultsLimit ,$resultsLimit*($page-1));

            $query = $this->getDoctrine()->getEntityManager()->createQuery("SELECT p FROM App\Entity\Players p WHERE p.groupId <= {$accessLimit} ORDER BY p.skillDist DESC, p.skillDistTries DESC, p.name ASC");
            $query->setMaxResults($resultsLimit)->setFirstResult($resultsLimit*($page-1));
 
            $result = $query->getResult();

            $filterName = "Distance Fighting";
        }

        elseif ($filter === "shielding"){
            // $result = $this->getDoctrine()
            //     ->getRepository(Players::class)
            // ->findBy([
            //     'groupId' => 1,
            // ],[
            //     'skillShielding' => "DESC"
            // ], $resultsLimit ,$resultsLimit*($page-1));

            $query = $this->getDoctrine()->getEntityManager()->createQuery("SELECT p FROM App\Entity\Players p WHERE p.groupId <= {$accessLimit} ORDER BY p.skillShielding DESC, p.skillShieldingTries DESC, p.name ASC");
            $query->setMaxResults($resultsLimit)->setFirstResult($resultsLimit*($page-1));
 
            $result = $query->getResult();

            $filterName = "Shielding";
        }

        elseif ($filter === "fishing"){
            // $result = $this->getDoctrine()
            //     ->getRepository(Players::class)
            // ->findBy([
            //     'groupId' => 1,
            // ],[
            //     'skillFishing' => "DESC"
            // ], $resultsLimit ,$resultsLimit*($page-1));

            $query = $this->getDoctrine()->getEntityManager()->createQuery("SELECT p FROM App\Entity\Players p WHERE p.groupId <= {$accessLimit} ORDER BY p.skillFishing DESC, p.skillFishingTries DESC, p.name ASC");
            $query->setMaxResults($resultsLimit)->setFirstResult($resultsLimit*($page-1));
 
            $result = $query->getResult();

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
