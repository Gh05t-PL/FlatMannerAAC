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
        /*
        * Config
        */
        $resultsLimit = 15;
        $accessLimit = 3;


        // GET COUNT OF POSSIBLE RESULTS exclude group <= accessLimit AND player.id = 1
        $query = $this->getDoctrine()->getEntityManager()->createQuery("SELECT p FROM App\Entity\Players p WHERE p.groupId <= {$accessLimit} AND p.id > 1 ORDER BY p.level DESC, p.experience DESC, p.name ASC");

        $possibleCount = count($query->getResult());

        // GET POSSIBLE COUNT OF PAGES
        $pagesCount = ceil(($possibleCount / $resultsLimit));
        
        
        //----LEVEL AND MLVL
        if ($filter === "level"){

            // fetch players with tutors and senior tutors
            $query = $this->getDoctrine()->getEntityManager()->createQuery("SELECT p FROM App\Entity\Players p WHERE p.groupId <= {$accessLimit} AND p.id > 1 ORDER BY p.level DESC, p.experience DESC, p.name ASC");
            $query->setMaxResults($resultsLimit)->setFirstResult($resultsLimit*($page-1));

            $result = $query->getResult();
            //var_dump($users);

            $filterName = "Level";
        }

        elseif ($filter === "mlvl"){

            // fetch players with tutors and senior tutors
            $query = $this->getDoctrine()->getEntityManager()->createQuery("SELECT p FROM App\Entity\Players p WHERE p.groupId <= {$accessLimit} AND p.id > 1 ORDER BY p.maglevel DESC, p.manaspent DESC, p.name ASC");
            $query->setMaxResults($resultsLimit)->setFirstResult($resultsLimit*($page-1));

            $result = $query->getResult();


            $filterName = "Magic Level";
        }
        //----SKILLS
        elseif ($filter === "fist"){

            // fetch players with tutors and senior tutors
            $query = $this->getDoctrine()->getEntityManager()->createQuery("SELECT s, p FROM App\Entity\PlayerSkill s JOIN s.player p WHERE s.skillid = 0 AND p.groupId <= {$accessLimit} ORDER BY s.value DESC, s.count DESC, p.name ASC");
            $query->setMaxResults($resultsLimit)->setFirstResult($resultsLimit*($page-1));

            $result = $query->getResult();

            $filterName = "Fist Fighting";
        }

        elseif ($filter === "club"){

            // fetch players with tutors and senior tutors
            $query = $this->getDoctrine()->getEntityManager()->createQuery("SELECT s, p FROM App\Entity\PlayerSkill s JOIN s.player p WHERE s.skillid = 1 AND p.groupId <= {$accessLimit} ORDER BY s.value DESC, s.count DESC, p.name ASC");
            $query->setMaxResults($resultsLimit)->setFirstResult($resultsLimit*($page-1));

            $result = $query->getResult();

            $filterName = "Club Fighting";
        }

        elseif ($filter === "sword"){

            // fetch players with tutors and senior tutors
            $query = $this->getDoctrine()->getEntityManager()->createQuery("SELECT s, p FROM App\Entity\PlayerSkill s JOIN s.player p WHERE s.skillid = 2 AND p.groupId <= {$accessLimit} ORDER BY s.value DESC, s.count DESC, p.name ASC");
            $query->setMaxResults($resultsLimit)->setFirstResult($resultsLimit*($page-1));

            $result = $query->getResult();

            $filterName = "Sword Fighting";
        }

        elseif ($filter === "axe"){
            
            // fetch players with tutors and senior tutors
            $query = $this->getDoctrine()->getEntityManager()->createQuery("SELECT s, p FROM App\Entity\PlayerSkill s JOIN s.player p WHERE s.skillid = 3 AND p.groupId <= {$accessLimit} ORDER BY s.value DESC, s.count DESC, p.name ASC");
            $query->setMaxResults($resultsLimit)->setFirstResult($resultsLimit*($page-1));

            $result = $query->getResult();

            $filterName = "Axe Fighting";
        }

        elseif ($filter === "distance"){
            
            // fetch players with tutors and senior tutors
            $query = $this->getDoctrine()->getEntityManager()->createQuery("SELECT s, p FROM App\Entity\PlayerSkill s JOIN s.player p WHERE s.skillid = 4 AND p.groupId <= {$accessLimit} ORDER BY s.value DESC, s.count DESC, p.name ASC");
            $query->setMaxResults($resultsLimit)->setFirstResult($resultsLimit*($page-1));

            $result = $query->getResult();

            $filterName = "Distance Fighting";
        }

        elseif ($filter === "shielding"){
            
            // fetch players with tutors and senior tutors
            $query = $this->getDoctrine()->getEntityManager()->createQuery("SELECT s, p FROM App\Entity\PlayerSkill s JOIN s.player p WHERE s.skillid = 5 AND p.groupId <= {$accessLimit} ORDER BY s.value DESC, s.count DESC, p.name ASC");
            $query->setMaxResults($resultsLimit)->setFirstResult($resultsLimit*($page-1));

            $result = $query->getResult();

            $filterName = "Shielding";
        }

        elseif ($filter === "fishing"){
            
            // fetch players with tutors and senior tutors
            $query = $this->getDoctrine()->getEntityManager()->createQuery("SELECT s, p FROM App\Entity\PlayerSkill s JOIN s.player p WHERE s.skillid = 6 AND p.groupId <= {$accessLimit} ORDER BY s.value DESC, s.count DESC, p.name ASC");
            $query->setMaxResults($resultsLimit)->setFirstResult($resultsLimit*($page-1));

            $result = $query->getResult();

            $filterName = "Fishing";
        }

        // if page has no results redirect to last page
        if (count($result) == 0){
            $query = $this->getDoctrine()->getEntityManager()->createQuery("SELECT p FROM App\Entity\Players p WHERE p.groupId <= {$accessLimit} AND p.id > 1 ORDER BY p.level DESC, p.experience DESC, p.name ASC");
            $count = count($query->getResult());

            
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
