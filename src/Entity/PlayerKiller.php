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
    public $kill;

    /**
     * @var App\Entity\Players
     *
     * @ORM\OneToOne(targetEntity="App\Entity\Players")
     * @ORM\JoinColumn(name="player_id", referencedColumnName="id")
     */
    public $killer;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;
}