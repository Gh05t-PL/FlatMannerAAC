<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PlayerKiller
 *
 * @ORM\Table(name="player_killers", uniqueConstraints={@ORM\UniqueConstraint(name="name", columns={"name"})})
 * @ORM\Entity
 */
class PlayerKiller
{
    /**
     * @var int
     *
     * @ORM\OneToOne(targetEntity="App\Entity\Killers")
     * @ORM\JoinColumn(name="kill_id", referencedColumnName="id")
     */
    private $kill;

    /**
     * @var App\Entity\Players
     *
     * @ORM\OneToOne(targetEntity="App\Entity\Players")
     * @ORM\JoinColumn(name="player_id", referencedColumnName="id")
     */
    private $killer;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @return int
     */
    public function getKill()
    {
        return $this->kill;
    }

    /**
     * @param int $kill
     */
    public function setKill($kill)
    {
        $this->kill = $kill;
    }

    /**
     * @return App\Entity\Players
     */
    public function getKiller()
    {
        return $this->killer;
    }

    /**
     * @param App\Entity\Players $killer
     */
    public function setKiller($killer)
    {
        $this->killer = $killer;
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






}