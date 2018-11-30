<?php

namespace App\Utils;

use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Utils\Strategy\StrategyClient;

class LoginHelper
{
    private $session, $strategy;

    public function __construct(SessionInterface $session, StrategyClient $strategy)
    {
        $this->session = $session;
        $this->strategy = $strategy;
    }

    public function logout()
    {
        if ( $this->isLoggedIn() )
            $this->session->remove('account_id');
    }

    public function isLoggedIn()
    {
        if ( $this->session->get("account_id") !== null )
        {
            return true;
        }
        return false;
    }

    public function getAccess()
    {
        $account = $this->strategy->getAccounts()->getAccountById($this->session->get("account_id"));

        return $account->getGroupId();
    }

    public function isAdmin()
    {
        return $this->getAccess() >= 7;
    }

    public function login(int $id)
    {
        $this->session->set('account_id', $id);
    }

    public function getAccountId()
    {
        return (int)$this->session->get("account_id");
    }
}