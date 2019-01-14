<?php

namespace App\Utils\Strategy\TFS12;


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
            ->createNativeQuery("SELECT p.id as pid, p.name as name, expires_at as expires, banned_at FROM players p INNER JOIN (SELECT banned_at, expires_at,account_id FROM account_bans b WHERE b.expires_at > UNIX_TIMESTAMP()) t2 on p.account_id = t2.account_id", $rsm);
        $query->setParameter(1, time());

        $result = $query->getResult();

        return $result;
    }


}