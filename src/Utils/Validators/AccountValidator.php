<?php
/**
 * Created by PhpStorm.
 * User: wiktor
 * Date: 27.11.2018
 * Time: 12:42
 */

namespace App\Utils\Validators;


use App\Utils\Strategy\StrategyClient;

class AccountValidator
{
    private $strategy;


    public function __construct(StrategyClient $strategy)
    {
        $this->strategy = $strategy;
    }

    public function isNameTaken(string $name)
    {
        if ( $this->strategy->getAccounts()->getAccountBy(['name' => $name]) == null )
            return false;
        return true;

    }

    public function isValidCredentials(string $name, string $password)
    {
        if ( $this->strategy->getAccounts()->getAccountBy(['name' => $name, 'password' => $password]) == null )
            return false;
        return true;
    }

    public function isProperLenght(int $from, int $to, string $str)
    {
        return strlen($str) >= $from && strlen($str) <= $to;
    }
}