<?php
namespace App\Utils\Strategy;

use App\Utils\Configs;

class StrategyClient
{
    private $strategies;

    public function __construct($doctrine)
    {
        if ( Configs::$config['version'] == "0.4" )
        {
            $this->strategies = [
                'accounts' => new Accounts\AccountsStrategy04($doctrine),
                'news' => new News\NewsStrategy04($doctrine),
                'players' => new Players\PlayersStrategy04($doctrine),
                'highscores' => new Highscores\HighscoreStrategy04($doctrine),
                'guilds' => new Guilds\GuildsStrategy04($doctrine),
            ];
        }
        elseif ( Configs::$config['version'] == "1.2" )
        {
            $this->strategies = [
                'accounts' => new Accounts\AccountsStrategy12($doctrine),
                'news' => new News\NewsStrategy12($doctrine),
                'players' => new Players\PlayersStrategy12($doctrine),
                'highscores' => new Highscores\HighscoreStrategy12($doctrine),
                'guilds' => new Guilds\GuildsStrategy12($doctrine),
            ];
        }
        else
        {
            throw new UnsupportedServerVersionException;
        }
    }


    public function __get($property)
    {
        return $this->strategies[strtolower($property)];
    }
}
