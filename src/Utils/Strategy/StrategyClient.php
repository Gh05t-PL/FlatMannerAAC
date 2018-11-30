<?php

namespace App\Utils\Strategy;

use App\Utils\Configs;

class StrategyClient
{
    private $strategies;

    public function __construct(\Symfony\Bridge\Doctrine\RegistryInterface $doctrine)
    {
        //Configs::$config['version']
        $strategies = [
            'accounts' => "App\Utils\Strategy\Accounts\AccountsStrategy",
            'news' => "App\Utils\Strategy\News\NewsStrategy",
            'players' => "App\Utils\Strategy\Players\PlayersStrategy",
            'highscores' => "App\Utils\Strategy\Highscores\HighscoreStrategy",
            'guilds' => "App\Utils\Strategy\Guilds\GuildsStrategy",
            'bans' => "App\Utils\Strategy\Bans\BansStrategy",
        ];

        foreach ($strategies as $key => $value)
        {
            $val = $value . str_replace(".", "", Configs::$config['version']);
            if ( !class_exists($val) )
                throw new \Exception("Unsupported Server Version Exception");
            $this->strategies[$key] = new $val($doctrine);
        }

    }

/*
    public function __get($property)
    {
        return $this->strategies[strtolower($property)];
    }
*/
    public function getAccounts(): \App\Utils\Strategy\Accounts\IAccountsStrategy
    {
        return $this->strategies['accounts'];
    }

    public function getNews(): \App\Utils\Strategy\News\INewsStrategy
    {
        return $this->strategies['news'];
    }

    public function getPlayers(): \App\Utils\Strategy\Players\IPlayersStrategy
    {
        return $this->strategies['players'];
    }

    public function getHighscores(): \App\Utils\Strategy\Highscores\IHighscoreStrategy
    {
        return $this->strategies['highscores'];
    }

    public function getGuilds(): \App\Utils\Strategy\Guilds\IGuildsStrategy
    {
        return $this->strategies['guilds'];
    }

    public function getBans(): \App\Utils\Strategy\Bans\IBansStrategy
    {
        return $this->strategies['bans'];
    }
}
