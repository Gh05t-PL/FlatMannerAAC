<?php

namespace App\Utils\Strategy\Players;

interface IPlayersStrategy
{

    public function getPlayerByName($name);

    public function getPlayerBy($criteria);

    public function getOnlinePlayers();

}