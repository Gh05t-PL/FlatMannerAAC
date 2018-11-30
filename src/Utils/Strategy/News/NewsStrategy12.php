<?php

namespace App\Utils\Strategy\News;


use Doctrine\ORM\Query\ResultSetMapping;
use Symfony\Bridge\Doctrine\RegistryInterface;

class NewsStrategy12 implements INewsStrategy
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
            ->getRepository(\App\Entity\TFS12\Accounts::class)
            ->find($id);

        if ( $account->getType() >= 7 )
            return true;
        else
            return false;
    }

}