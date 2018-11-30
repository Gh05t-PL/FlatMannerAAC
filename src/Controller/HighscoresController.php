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

use App\Utils\Strategy\StrategyClient;

use App\Utils\Configs;


class HighscoresController extends Controller
{
    /**
     * @Route("/highscores/{filter}/{page}", name="highscores_level", requirements={
     *      "page"="\d+",
     *      "filter"="level|mlvl|fist|club|sword|axe|distance|shielding|fishing"
     * })
     */
    public function highscores($filter = "level", $page = 1, SessionInterface $session, StrategyClient $strategy)
    {
        /*
        * Config
        */
        $resultsLimit = 15;
        $accessLimit = 3;


        // GET COUNT OF POSSIBLE RESULTS exclude group <= accessLimit AND player.id = 1
        $query = $this->getDoctrine()->getManager()->createQuery("SELECT p FROM App\Entity\Players12 p WHERE p.groupId <= {$accessLimit} AND p.id > 1 ORDER BY p.level DESC, p.experience DESC, p.name ASC");

        $possibleCount = $strategy->getHighscores()->getPossibleCount();

        // GET POSSIBLE COUNT OF PAGES
        $pagesCount = ceil(($possibleCount / $resultsLimit));


        //----LEVEL AND MLVL
        if ( $filter === "level" )
        {

            // // fetch players with tutors and senior tutors
            // $query = $this->getDoctrine()->getEntityManager()->createQuery("SELECT p FROM App\Entity\Players p WHERE p.groupId <= {$accessLimit} AND p.id > 1 ORDER BY p.level DESC, p.experience DESC, p.name ASC");
            // $query->setMaxResults($resultsLimit)->setFirstResult($resultsLimit*($page-1));

            // $result = $query->getResult();
            // //var_dump($users);
            $result = $strategy->getHighscores()->getHighscoresLevels($filter, $resultsLimit, $page);

            $filterName = "Level";
        } elseif ( $filter === "mlvl" )
        {

            // // fetch players with tutors and senior tutors
            // $query = $this->getDoctrine()->getEntityManager()->createQuery("SELECT p FROM App\Entity\Players p WHERE p.groupId <= {$accessLimit} AND p.id > 1 ORDER BY p.maglevel DESC, p.manaspent DESC, p.name ASC");
            // $query->setMaxResults($resultsLimit)->setFirstResult($resultsLimit*($page-1));

            // $result = $query->getResult();
            $result = $strategy->getHighscores()->getHighscoresLevels($filter, $resultsLimit, $page);

            $filterName = "Magic Level";
        } //----SKILLS
        elseif ( $filter === "fist" )
        {

            // // fetch players with tutors and senior tutors
            // $query = $this->getDoctrine()->getEntityManager()->createQuery("SELECT s, p FROM App\Entity\PlayerSkill s JOIN s.player p WHERE s.skillid = 0 AND p.groupId <= {$accessLimit} AND p.id > 1 ORDER BY s.value DESC, s.count DESC, p.name ASC");
            // $query->setMaxResults($resultsLimit)->setFirstResult($resultsLimit*($page-1));
            // 
            // $result = $query->getResult();
            $result = $strategy->getHighscores()->getHighscoresSkills(0, $resultsLimit, $page);

            $filterName = "Fist Fighting";
        } elseif ( $filter === "club" )
        {

            // // fetch players with tutors and senior tutors
            // $query = $this->getDoctrine()->getEntityManager()->createQuery("SELECT s, p FROM App\Entity\PlayerSkill s JOIN s.player p WHERE s.skillid = 1 AND p.groupId <= {$accessLimit} AND p.id > 1 ORDER BY s.value DESC, s.count DESC, p.name ASC");
            // $query->setMaxResults($resultsLimit)->setFirstResult($resultsLimit*($page-1));

            // $result = $query->getResult();
            $result = $strategy->getHighscores()->getHighscoresSkills(1, $resultsLimit, $page);

            $filterName = "Club Fighting";
        } elseif ( $filter === "sword" )
        {

            // // fetch players with tutors and senior tutors
            // $query = $this->getDoctrine()->getEntityManager()->createQuery("SELECT s, p FROM App\Entity\PlayerSkill s JOIN s.player p WHERE s.skillid = 2 AND p.groupId <= {$accessLimit} AND p.id > 1 ORDER BY s.value DESC, s.count DESC, p.name ASC");
            // $query->setMaxResults($resultsLimit)->setFirstResult($resultsLimit*($page-1));

            // $result = $query->getResult();
            $result = $strategy->getHighscores()->getHighscoresSkills(2, $resultsLimit, $page);

            $filterName = "Sword Fighting";
        } elseif ( $filter === "axe" )
        {

            // // fetch players with tutors and senior tutors
            // $query = $this->getDoctrine()->getEntityManager()->createQuery("SELECT s, p FROM App\Entity\PlayerSkill s JOIN s.player p WHERE s.skillid = 3 AND p.groupId <= {$accessLimit} AND p.id > 1 ORDER BY s.value DESC, s.count DESC, p.name ASC");
            // $query->setMaxResults($resultsLimit)->setFirstResult($resultsLimit*($page-1));

            // $result = $query->getResult();
            $result = $strategy->getHighscores()->getHighscoresSkills(3, $resultsLimit, $page);

            $filterName = "Axe Fighting";
        } elseif ( $filter === "distance" )
        {

            // // fetch players with tutors and senior tutors
            // $query = $this->getDoctrine()->getEntityManager()->createQuery("SELECT s, p FROM App\Entity\PlayerSkill s JOIN s.player p WHERE s.skillid = 4 AND p.groupId <= {$accessLimit} AND p.id > 1 ORDER BY s.value DESC, s.count DESC, p.name ASC");
            // $query->setMaxResults($resultsLimit)->setFirstResult($resultsLimit*($page-1));

            // $result = $query->getResult();
            $result = $strategy->getHighscores()->getHighscoresSkills(4, $resultsLimit, $page);

            $filterName = "Distance Fighting";
        } elseif ( $filter === "shielding" )
        {

            // // fetch players with tutors and senior tutors
            // $query = $this->getDoctrine()->getEntityManager()->createQuery("SELECT s, p FROM App\Entity\PlayerSkill s JOIN s.player p WHERE s.skillid = 5 AND p.groupId <= {$accessLimit} AND p.id > 1 ORDER BY s.value DESC, s.count DESC, p.name ASC");
            // $query->setMaxResults($resultsLimit)->setFirstResult($resultsLimit*($page-1));

            // $result = $query->getResult();
            $result = $strategy->getHighscores()->getHighscoresSkills(5, $resultsLimit, $page);

            $filterName = "Shielding";
        } elseif ( $filter === "fishing" )
        {

            // // fetch players with tutors and senior tutors
            // $query = $this->getDoctrine()->getEntityManager()->createQuery("SELECT s, p FROM App\Entity\PlayerSkill s JOIN s.player p WHERE s.skillid = 6 AND p.groupId <= {$accessLimit} AND p.id > 1 ORDER BY s.value DESC, s.count DESC, p.name ASC");
            // $query->setMaxResults($resultsLimit)->setFirstResult($resultsLimit*($page-1));

            // $result = $query->getResult();
            $result = $strategy->getHighscores()->getHighscoresSkills(6, $resultsLimit, $page);

            $filterName = "Fishing";
        }

        // if page has no results redirect to last page
        if ( empty($result) )
        {
            $query = $this->getDoctrine()->getManager()->createQuery("SELECT p FROM App\Entity\Players p WHERE p.groupId <= {$accessLimit} AND p.id > 1 ORDER BY p.level DESC, p.experience DESC, p.name ASC");
            $count = count($query->getResult());

            //var_dump($redirPage);
            $redirPage = ceil((int)$count / (float)$resultsLimit);
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
