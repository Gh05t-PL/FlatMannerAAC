<?php

namespace App\Entity\TFS12;

use Doctrine\ORM\Mapping as ORM;

/**
 * AccountBanHistory
 *
 * @ORM\Table(name="account_ban_history", indexes={@ORM\Index(name="account_id", columns={"account_id"}), @ORM\Index(name="banned_by", columns={"banned_by"})})
 * @ORM\Entity
 */
class AccountBanHistory
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

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
     * @ORM\Column(name="expired_at", type="bigint", nullable=false)
     */
    private $expiredAt;

    /**
     * @var \Accounts
     *
     * @ORM\ManyToOne(targetEntity="Accounts")
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

    public function getId(): ?int
    {
        return $this->id;
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

    public function getExpiredAt(): ?int
    {
        return $this->expiredAt;
    }

    public function setExpiredAt(int $expiredAt): self
    {
        $this->expiredAt = $expiredAt;

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
