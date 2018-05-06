<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * GuildMembership
 *
 * @ORM\Table(name="guild_membership", indexes={@ORM\Index(name="guild_id", columns={"guild_id"}), @ORM\Index(name="rank_id", columns={"rank_id"})})
 * @ORM\Entity
 */
class GuildMembership
{
    /**
     * @var string
     *
     * @ORM\Column(name="nick", type="string", length=15, nullable=false)
     */
    private $nick = '';

    /**
     * @var \Players
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Players")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="player_id", referencedColumnName="id")
     * })
     */
    private $player;

    /**
     * @var \Guilds
     *
     * @ORM\ManyToOne(targetEntity="Guilds")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="guild_id", referencedColumnName="id")
     * })
     */
    private $guild;

    /**
     * @var \GuildRanks
     *
     * @ORM\ManyToOne(targetEntity="GuildRanks")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="rank_id", referencedColumnName="id")
     * })
     */
    private $rank;

    public function getNick(): ?string
    {
        return $this->nick;
    }

    public function setNick(string $nick): self
    {
        $this->nick = $nick;

        return $this;
    }

    public function getPlayer(): ?Players
    {
        return $this->player;
    }

    public function setPlayer(?Players $player): self
    {
        $this->player = $player;

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

    public function getRank(): ?GuildRanks
    {
        return $this->rank;
    }

    public function setRank(?GuildRanks $rank): self
    {
        $this->rank = $rank;

        return $this;
    }


}
