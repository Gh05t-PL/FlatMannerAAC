<?php
namespace App\Utils\Strategy\News;


use Doctrine\ORM\Query\ResultSetMapping;
use Symfony\Bridge\Doctrine\RegistryInterface;

class NewsStrategy12
{

    private $doctrine;

    public function __construct(RegistryInterface $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    function isAdmin($id){
        $account = $this->doctrine
                ->getRepository(\App\Entity\Accounts12::class)
        ->find($id);

        if ( $account->getType() >= 7 )
            return true;
        else
            return false;
    }

}