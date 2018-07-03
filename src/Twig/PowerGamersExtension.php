<?php

namespace App\Twig;

use Extension\AbstractExtension;
use Twig\TwigFilter;
use Doctrine\ORM\Query\ResultSetMapping;
use Symfony\Bridge\Doctrine\RegistryInterface;

use \Twig_Function;

class PowerGamersExtension extends \Twig_Extension
{


    protected $doctrine;
    // Retrieve doctrine from the container

    public function __construct(RegistryInterface $doctrine)
    {
        $this->doctrine = $doctrine;
    }


    public function getPowerGamers()
    {
        
        $rsm = new ResultSetMapping;
        $rsm->addScalarResult('name', 'name');
        $rsm->addScalarResult('expDiff', 'expDiff');

        $powerGamers = $this->doctrine->getManager()
            ->createNativeQuery("SELECT name,id,(t1.experience - expBefore) as expDiff FROM players t1 INNER JOIN (SELECT player_id, exp as expBefore FROM today_exp) t2 ON t1.id = t2.player_id WHERE group_id <= 3 AND id > 1 ORDER BY expDiff DESC LIMIT 5", $rsm)
        ->getResult();

        return $powerGamers;
    }




    public function getFunctions()
    {
        return array(
            'getPowerGamers' => new Twig_Function('getPowerGamers', [$this, 'getPowerGamers']),
        );
    }











}