<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AccountBans
 *
 * @ORM\Table(name="account_bans", indexes={@ORM\Index(name="banned_by", columns={"banned_by"})})
 * @ORM\Entity
 */
class AccountBans
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
     * @var \Accounts
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Accounts")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="account_id", referencedColumnName="id")
     * })
     */
    private $account;

    /**
     * @var \Players
     *
     * @ORM\ManyToOne(targetEntity="Players")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="banned_by", referencedColumnName="id")
     * })
     */
    private $bannedBy;

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

    public function getAccount(): ?Accounts
    {
        return $this->account;
    }

    public function setAccount(?Accounts $account): self
    {
        $this->account = $account;

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
