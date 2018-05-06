<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * IpBans
 *
 * @ORM\Table(name="ip_bans", indexes={@ORM\Index(name="banned_by", columns={"banned_by"})})
 * @ORM\Entity
 */
class IpBans
{
    /**
     * @var int
     *
     * @ORM\Column(name="ip", type="integer", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $ip;

    /**
     * @var string
     *
     * @ORM\Column(name="reason", type="string", length=255, nullable=false)
     */
    private $reason;

    /**
     * @var int
     *
     * @ORM\Column(name="banned_at", type="bigint", nullable=false)
     */
    private $bannedAt;

    /**
     * @var int
     *
     * @ORM\Column(name="expires_at", type="bigint", nullable=false)
     */
    private $expiresAt;

    /**
     * @var \Players
     *
     * @ORM\ManyToOne(targetEntity="Players")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="banned_by", referencedColumnName="id")
     * })
     */
    private $bannedBy;

    public function getIp(): ?int
    {
        return $this->ip;
    }

    public function getReason(): ?string
    {
        return $this->reason;
    }

    public function setReason(string $reason): self
    {
        $this->reason = $reason;

        return $this;
    }

    public function getBannedAt(): ?int
    {
        return $this->bannedAt;
    }

    public function setBannedAt(int $bannedAt): self
    {
        $this->bannedAt = $bannedAt;

        return $this;
    }

    public function getExpiresAt(): ?int
    {
        return $this->expiresAt;
    }

    public function setExpiresAt(int $expiresAt): self
    {
        $this->expiresAt = $expiresAt;

        return $this;
    }

    public function getBannedBy(): ?Players
    {
        return $this->bannedBy;
    }

    public function setBannedBy(?Players $bannedBy): self
    {
        $this->bannedBy = $bannedBy;

        return $this;
    }


}
