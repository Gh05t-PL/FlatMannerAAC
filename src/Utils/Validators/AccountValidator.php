<?php
/**
 * Created by PhpStorm.
 * User: wiktor
 * Date: 27.11.2018
 * Time: 12:42
 */

namespace App\Utils\Validators;


use App\Utils\Configs;
use App\Utils\Strategy\StrategyClient;

class AccountValidator
{
    private $strategy;


    public function __construct(StrategyClient $strategy)
    {
        $this->strategy = $strategy;
    }

    public function isNameTaken(string $name): bool
    {
        if ( $this->strategy->getAccounts()->getAccountBy(['name' => $name]) == null )
            return false;
        return true;

    }

    public function isValidCredentials(string $name, string $password): bool
    {
        if ( $this->strategy->getAccounts()->getAccountBy(['name' => $name, 'password' => $this->encodePassword($password)]) == null )
            return false;
        return true;
    }

    /**
     * Returns encoded password or plain text depends on Configs::$config['passwordHashing'] and is passed to \hash(string $algo, string $data)
     *
     * @param string $password password string encoded with certain hash algorithm
     * @return string hashed password OR plain text password
     */
    private function encodePassword(string $password): string
    {
        if ( Configs::$config['passwordHashing'] === "plain" )
            return $password;
        return \hash(Configs::$config['passwordHashing'], $password);
    }

    public function isProperLenght(int $from, int $to, string $str): bool
    {
        return strlen($str) >= $from && strlen($str) <= $to;
    }
}