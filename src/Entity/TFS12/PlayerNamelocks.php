<?php

namespace App\Entity\TFS12;

use Doctrine\ORM\Mapping as ORM;

/**
 * PlayerNamelocks
 *
 * @ORM\Table(name="player_namelocks", indexes={@ORM\Index(name="namelocked_by", columns={"namelocked_by"})})
 * @ORM\Entity
 */
class PlayerNamelocks
{
    /**
     * @var string
     *
     * @ORM\Column(name="reason", type="string", length=255, nullable=false)
     */
    private $reason;

    /**
     * @var int
     *
     * @ORM\Column(name="namelocked_at", type="bigint", nullable=false)
     */
    private $namelockedAt;

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
     * @var \Players
     *
     * @ORM\ManyToOne(targetEntity="Players")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="namelocked_by", referencedColumnName="id")
     * })
     */
    private $namelockedBy;

    public function getReason(): ?string
    {
        return $this->reason;
    }

    public function setReason(string $reason): self
    {
        $this->reason = $reason;

        return $this;
    }

    public function getNamelockedAt(): ?int
    {
        return $this->namelockedAt;
    }

    public function setNamelockedAt(int $namelockedAt): self
    {
        $this->namelockedAt = $namelockedAt;

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

    public function getNamelockedBy(): ?Players
    {
        return $this->namelockedBy;
    }

    public function setNamelockedBy(?Players $namelockedBy): self
    {
        $this->namelockedBy = $namelockedBy;

        return $this;
    }


}
