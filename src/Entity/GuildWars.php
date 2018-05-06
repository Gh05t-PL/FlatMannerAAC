<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * GuildWars
 *
 * @ORM\Table(name="guild_wars", indexes={@ORM\Index(name="guild1", columns={"guild1"}), @ORM\Index(name="guild2", columns={"guild2"})})
 * @ORM\Entity
 */
class GuildWars
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
     * @var int
     *
     * @ORM\Column(name="guild1", type="integer", nullable=false)
     */
    private $guild1 = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="guild2", type="integer", nullable=false)
     */
    private $guild2 = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="name1", type="string", length=255, nullable=false)
     */
    private $name1;

    /**
     * @var string
     *
     * @ORM\Column(name="name2", type="string", length=255, nullable=false)
     */
    private $name2;

    /**
     * @var bool
     *
     * @ORM\Column(name="status", type="boolean", nullable=false)
     */
    private $status = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="started", type="bigint", nullable=false)
     */
    private $started = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="ended", type="bigint", nullable=false)
     */
    private $ended = '0';

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGuild1(): ?int
    {
        return $this->guild1;
    }

    public function setGuild1(int $guild1): self
    {
        $this->guild1 = $guild1;

        return $this;
    }

    public function getGuild2(): ?int
    {
        return $this->guild2;
    }

    public function setGuild2(int $guild2): self
    {
        $this->guild2 = $guild2;

        return $this;
    }

    public function getName1(): ?string
    {
        return $this->name1;
    }

    public function setName1(string $name1): self
    {
        $this->name1 = $name1;

        return $this;
    }

    public function getName2(): ?string
    {
        return $this->name2;
    }

    public function setName2(string $name2): self
    {
        $this->name2 = $name2;

        return $this;
    }

    public function getStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getStarted(): ?int
    {
        return $this->started;
    }

    public function setStarted(int $started): self
    {
        $this->started = $started;

        return $this;
    }

    public function getEnded(): ?int
    {
        return $this->ended;
    }

    public function setEnded(int $ended): self
    {
        $this->ended = $ended;

        return $this;
    }


}
