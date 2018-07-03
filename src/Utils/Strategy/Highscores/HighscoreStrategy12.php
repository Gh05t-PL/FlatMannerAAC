<?php
namespace App\Utils\Strategy\Highscores;


use Doctrine\ORM\Query\ResultSetMapping;

class HighscoreStrategy12 implements IHighscoreStrategy
{

    private $doctrine;

    public function __construct($doctrine)
    {
        $this->doctrine = $doctrine;
    }


    function getPossibleCount()
    {
        $accessLimit = 3;
        $query = $this->doctrine->getManager()->createQuery("SELECT p FROM App\Entity\TFS12\Players p WHERE p.groupId <= {$accessLimit} AND p.id > 1 ORDER BY p.level DESC, p.experience DESC, p.name ASC");
    
        $possibleCount = count($query->getResult());

        return $possibleCount;
    }


    function getHighscoresSkills($skillId, $resultsLimit, $page)
    {
        /*
            0:Fist
            1:Club
            2:Sword
            3:Axe
            4: Distance
            5:Shield
            6:Fishing
            CONFIG__
        */
        $accessLimit = 3;
        $config['ver'] = "1.2";

        $skills = [
            0 => 'skillFist',
            1 => 'skillClub',
            2 => 'skillSword',
            3 => 'skillAxe',
            4 => 'skillDist',
            5 => 'skillShielding',
            6 => 'skillFishing',
        ];
        $tries = $skills[$skillId] . 'Tries';
        $query = $this->doctrine->getManager()->createQuery("SELECT p FROM App\Entity\TFS12\Players p WHERE p.groupId <= {$accessLimit} ORDER BY p.{$skills[$skillId]} DESC, p.{$tries} DESC, p.name ASC");
        $query->setMaxResults($resultsLimit)->setFirstResult($resultsLimit*($page-1));

        $result = $query->getResult();

        

        $getSkill = 'get' . $skills[$skillId];

        $resultFinal = [];
        foreach ($result as $key => $value) {
            $resultFinal[] = (object)[
                'name' => $value->getName(),
                'skill' => $value->$getSkill(),
                'groupid' => $value->getGroupid()
            ];
            //\var_dump($value->getSkillClub());
        }
        //\var_dump($resultFinal);
        return $resultFinal;
    }


    function getHighscoresLevels($filter, $resultsLimit, $page)
    {
        /*
        *
        *CONFIG__
        */
        $accessLimit = 3;
        $config['ver'] = "1.2";
        $result = null;
        $orders = [
            'level' => ['level','experience'],
            'mlvl' => ['maglevel','manaspent']
        ];
        
        if ($filter === "level"){
            $query = $this->doctrine->getManager()->createQuery("SELECT p FROM App\Entity\TFS12\Players p WHERE p.groupId <= {$accessLimit} ORDER BY p.{$orders[$filter][0]} DESC, p.{$orders[$filter][1]} DESC, p.name ASC");
            $query->setMaxResults($resultsLimit)->setFirstResult($resultsLimit*($page-1));

            $result = $query->getResult();
        }elseif ($filter === "mlvl"){
            $query = $this->doctrine->getManager()->createQuery("SELECT p FROM App\Entity\TFS12\Players p WHERE p.groupId <= {$accessLimit} ORDER BY p.{$orders[$filter][0]} DESC, p.{$orders[$filter][1]} DESC, p.name ASC");
            $query->setMaxResults($resultsLimit)->setFirstResult($resultsLimit*($page-1));

            $result = $query->getResult();
        }
        

        $resultFinal = [];
        foreach ($result as $key => $value) {
            $resultFinal[] = (object)[
                'name' => $value->getName(),
                'level' => $value->getLevel(),
                'maglevel' => $value->getMaglevel(),
                'groupid' => $value->getGroupid()
            ];
        }
        //\var_dump($resultFinal);
        return $resultFinal;
    }
















    
}