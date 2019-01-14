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
            'accounts' => "AccountsStrategy",
            'news' => "NewsStrategy",
            'players' => "PlayersStrategy",
            'highscores' => "HighscoreStrategy",
            'guilds' => "GuildsStrategy",
            'bans' => "BansStrategy",
        ];

        foreach ($strategies as $key => $value)
        {
            $val = "App\\Utils\\Strategy\\" . str_replace(".", "", Configs::$config['version']) . "\\" . $value;
            if ( !class_exists($val) )
                throw new \Exception("Unsupported Server Version Exception (class " . $val . " Not Found)");
            $this->strategies[$key] = new $val($doctrine);
        }

    }

    public function getAccounts(): \App\Utils\Strategy\IAccountsStrategy
    {
        return $this->strategies['accounts'];
    }

    public function getNews(): \App\Utils\Strategy\INewsStrategy
    {
        return $this->strategies['news'];
    }

    public function getPlayers(): \App\Utils\Strategy\IPlayersStrategy
    {
        return $this->strategies['players'];
    }

    public function getHighscores(): \App\Utils\Strategy\IHighscoreStrategy
    {
        return $this->strategies['highscores'];
    }

    public function getGuilds(): \App\Utils\Strategy\IGuildsStrategy
    {
        return $this->strategies['guilds'];
    }

    public function getBans(): \App\Utils\Strategy\IBansStrategy
    {
        return $this->strategies['bans'];
    }
}
