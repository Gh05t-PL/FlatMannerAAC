<?php

namespace App\Utils\Strategy\Players;

use App\Utils\Strategy\UnifiedEntities\Player;

interface IPlayersStrategy
{

    public function getPlayerByName(string $name): Player;

    public function getPlayerBy($criteria);

    public function getOnlinePlayers();

}