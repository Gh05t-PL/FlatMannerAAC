<?php

namespace App\Entity\TFS04;

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
     * @var App\Entity\TFS04\Players
     *
     * @ORM\OneToOne(targetEntity="App\Entity\TFS04\Players")
     * @ORM\JoinColumn(name="`player_id`", referencedColumnName="id")
     */
    private $player;

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
    private $value;

    /**
     * @var int
     *
     * @ORM\Column(name="count", type="integer", nullable=false)
     */
    private $count;





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
     * @return App\Entity\TFS04\Players
     */
    public function getPlayer()
    {
        return $this->player;
    }

    /**
     * @param App\Entity\TFS04\Players $player
     */
    public function setPlayer($player)
    {
        $this->player = $player;
    }

    /**
     * @return int
     */
    public function getSkillid()
    {
        return $this->skillid;
    }

    /**
     * @param int $skillid
     */
    public function setSkillid($skillid)
    {
        $this->skillid = $skillid;
    }

    /**
     * @return int
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param int $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * @return int
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * @param int $count
     */
    public function setCount($count)
    {
        $this->count = $count;
    }





}
