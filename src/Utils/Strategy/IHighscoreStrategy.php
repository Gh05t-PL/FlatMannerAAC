<?php

namespace App\Utils\Strategy;

interface IHighscoreStrategy
{

    public function getPossibleCount();

    public function getHighscoresSkills($skillId, $resultsLimit, $page);

    public function getHighscoresLevels($filter, $resultsLimit, $page);

}