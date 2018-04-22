<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PlayerDeaths
 *
 * @ORM\Table(name="player_deaths", indexes={@ORM\Index(name="date", columns={"date"}), @ORM\Index(name="player_id", columns={"player_id"})})
 * @ORM\Entity
 */
class PlayerDeaths
{
    /**
     * @var int
     *
     * @ORM\Column(name="date", type="bigint", nullable=false, options={"unsigned"=true})
     */
    public $date;

    /**
     * @var int
     *
     * @ORM\Column(name="level", type="integer", nullable=false, options={"unsigned"=true})
     */
    public $level;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \App\Entity\Players
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Players")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="player_id", referencedColumnName="id")
     * })
     */
    public $player;


}
