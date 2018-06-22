<?php
namespace App\Utils\Strategy\Accounts;


use Doctrine\ORM\Query\ResultSetMapping;
class AccountsStrategy04
{

    private $doctrine;

    public function __construct($doctrine)
    {
        $this->doctrine = $doctrine;
    }


    public function getAccountById($id)
    {
        $account = $this->doctrine
            ->getRepository(\App\Entity\Accounts::class)
        ->find($id);

        return $account;
    }


    public function getAccountChars($id)
    {
        $chars = $this->doctrine
            ->getRepository(\App\Entity\Players04::class)
        ->findBy(['account' => $id]);

        return $chars;
    }


    public function getAccountBy($criteria)
    {
        $account = $this->doctrine
            ->getRepository(\App\Entity\Accounts::class)
        ->findOneBy($criteria);

        return $account;
    }
}