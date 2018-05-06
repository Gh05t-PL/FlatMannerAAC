<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PlayersOnline
 *
 * @ORM\Table(name="players_online")
 * @ORM\Entity
 */
class PlayersOnline
{
    /**
     * @var int
     *
     * @ORM\Column(name="player_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $playerId;

    public function getPlayerId(): ?int
    {
        return $this->playerId;
    }


}
