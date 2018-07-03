<?php
namespace App\Utils\Strategy\News;


use Doctrine\ORM\Query\ResultSetMapping;
use Symfony\Bridge\Doctrine\RegistryInterface;

class NewsStrategy04 implements INewsStrategy
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