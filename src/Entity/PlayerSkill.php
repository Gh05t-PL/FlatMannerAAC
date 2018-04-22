<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity(repositoryClass="App\Repository\PlayerSkillRepository")
 * @ORM\Table(name="player_skills")
 */
class PlayerSkill
{

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var App\Entity\Players
     *
     * @ORM\OneToOne(targetEntity="App\Entity\Players")
     * @ORM\JoinColumn(name="`player_id`", referencedColumnName="id")
     */
    public $player;

    /**
     * @var int
     *
     * @ORM\Column(name="skillid", type="integer", nullable=false)
     */
    private $skillid;

    /**
     * @var int
     *
     * @ORM\Column(name="value", type="integer", nullable=false)
     */
    public $value;

    /**
     * @var int
     *
     * @ORM\Column(name="count", type="integer", nullable=false)
     */
    private $count;













    public function getId()
    {
        return $this->id;
    }
}
