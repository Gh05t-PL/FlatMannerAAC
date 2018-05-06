<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * GuildwarKills
 *
 * @ORM\Table(name="guildwar_kills", indexes={@ORM\Index(name="warid", columns={"warid"})})
 * @ORM\Entity
 */
class GuildwarKills
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="killer", type="string", length=50, nullable=false)
     */
    private $killer;

    /**
     * @var string
     *
     * @ORM\Column(name="target", type="string", length=50, nullable=false)
     */
    private $target;

    /**
     * @var int
     *
     * @ORM\Column(name="killerguild", type="integer", nullable=false)
     */
    private $killerguild = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="targetguild", type="integer", nullable=false)
     */
    private $targetguild = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="time", type="bigint", nullable=false)
     */
    private $time;

    /**
     * @var \GuildWars
     *
     * @ORM\ManyToOne(targetEntity="GuildWars")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="warid", referencedColumnName="id")
     * })
     */
    private $warid;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getKiller(): ?string
    {
        return $this->killer;
    }

    public function setKiller(string $killer): self
    {
        $this->killer = $killer;

        return $this;
    }

    public function getTarget(): ?string
    {
        return $this->target;
    }

    public function setTarget(string $target): self
    {
        $this->target = $target;

        return $this;
    }

    public function getKillerguild(): ?int
    {
        return $this->killerguild;
    }

    public function setKillerguild(int $killerguild): self
    {
        $this->killerguild = $killerguild;

        return $this;
    }

    public function getTargetguild(): ?int
    {
        return $this->targetguild;
    }

    public function setTargetguild(int $targetguild): self
    {
        $this->targetguild = $targetguild;

        return $this;
    }

    public function getTime(): ?int
    {
        return $this->time;
    }

    public function setTime(int $time): self
    {
        $this->time = $time;

        return $this;
    }

    public function getWarid(): ?GuildWars
    {
        return $this->warid;
    }

    public function setWarid(?GuildWars $warid): self
    {
        $this->warid = $warid;

        return $this;
    }


}
