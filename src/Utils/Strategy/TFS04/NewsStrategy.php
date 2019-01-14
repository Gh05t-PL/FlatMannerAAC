<?php

namespace App\Utils\Strategy\TFS04;


use Doctrine\ORM\Query\ResultSetMapping;
use Symfony\Bridge\Doctrine\RegistryInterface;

class NewsStrategy implements \App\Utils\Strategy\INewsStrategy
{

    private $doctrine;

    public function __construct(RegistryInterface $doctrine)
    {
        $this->doctrine = $doctrine;
    }


    /**
     * CHECKERS
     */
    function isAdmin($id)
    {
        $account = $this->doctrine
            ->getRepository(\App\Entity\TFS04\Accounts::class)
            ->find($id);

        if ( $account->getGroupId() >= 7 )
            return true;
        else
            return false;
    }

}