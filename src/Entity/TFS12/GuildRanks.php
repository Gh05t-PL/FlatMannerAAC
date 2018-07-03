<?php

namespace App\Entity\TFS12;

use Doctrine\ORM\Mapping as ORM;

/**
 * GuildRanks
 *
 * @ORM\Table(name="guild_ranks", indexes={@ORM\Index(name="guild_id", columns={"guild_id"})})
 * @ORM\Entity
 */
class GuildRanks
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
     * @ORM\Column(name="name", type="string", length=255, nullable=false, options={"comment"="rank name"})
     */
    private $name;

    /**
     * @var int
     *
     * @ORM\Column(name="level", type="integer", nullable=false, options={"comment"="rank level - leader, vice, member, maybe something else"})
     */
    private $level;

    /**
     * @var \Guilds
     *
     * @ORM\ManyToOne(targetEntity="Guilds")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="guild_id", referencedColumnName="id")
     * })
     */
    private $guild;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getLevel(): ?int
    {
        return $this->level;
    }

    public function setLevel(int $level): self
    {
        $this->level = $level;

        return $this;
    }

    public function getGuild(): ?Guilds
    {
        return $this->guild;
    }

    public function setGuild(?Guilds $guild): self
    {
        $this->guild = $guild;

        return $this;
    }


}
