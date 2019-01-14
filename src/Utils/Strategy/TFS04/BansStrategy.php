<?php

namespace App\Utils\Strategy\TFS04;


use Doctrine\ORM\Query\ResultSetMapping;

class BansStrategy implements \App\Utils\Strategy\IBansStrategy
{

    private $doctrine;

    public function __construct($doctrine)
    {
        $this->doctrine = $doctrine;
    }


    public function getBansList()
    {
        $rsm = new ResultSetMapping;
        $rsm->addScalarResult('pid', 'pid');
        $rsm->addScalarResult('name', 'name');
        $rsm->addScalarResult('expires', 'expires');

        $query = $this->doctrine
            ->getManager()
            ->createNativeQuery("SELECT p.id as pid, p.name as name, expires FROM players p INNER JOIN (SELECT value, expires FROM bans b WHERE b.expires > UNIX_TIMESTAMP() AND b.type = 3) t2 on p.account_id = t2.value ORDER BY expires", $rsm);
        $query->setParameter(1, time());

        $result = $query->getResult();

        return $result;
    }


}