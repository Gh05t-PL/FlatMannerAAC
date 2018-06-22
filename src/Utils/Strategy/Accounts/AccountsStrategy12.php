<?php
namespace App\Utils\Strategy\Accounts;


use Doctrine\ORM\Query\ResultSetMapping;
class AccountsStrategy12
{

    private $doctrine;

    public function __construct($doctrine)
    {
        $this->doctrine = $doctrine;
    }


    public function getAccountById($id){
        $account = $this->doctrine
            ->getRepository(\App\Entity\Accounts12::class)
        ->find($id);

        return $account;
    }


    public function getAccountChars($id){
        $chars = $this->doctrine
            ->getRepository(\App\Entity\Players12::class)
        ->findBy(['account' => $id]);

        return $chars;
    }


    public function getAccountBy($criteria){
        if ( isset($criteria['password']) )
        $criteria['password'] = sha1($criteria['password']);
        $account = $this->doctrine
            ->getRepository(\App\Entity\Accounts12::class)
        ->findOneBy($criteria);

        return $account;
    }
    
}