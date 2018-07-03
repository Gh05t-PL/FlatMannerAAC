<?php

namespace App\Entity\TFS04;

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
    private $date;

    /**
     * @var int
     *
     * @ORM\Column(name="level", type="integer", nullable=false, options={"unsigned"=true})
     */
    private $level;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \App\Entity\TFS04\Players
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\TFS04\Players")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="player_id", referencedColumnName="id")
     * })
     */
    private $player;

    /**
     * @return int
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param int $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @return int
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * @param int $level
     */
    public function setLevel($level)
    {
        $this->level = $level;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return Players
     */
    public function getPlayer()
    {
        return $this->player;
    }

    /**
     * @param Players $player
     */
    public function setPlayer($player)
    {
        $this->player = $player;
    }







}
