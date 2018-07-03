<?php

namespace App\Entity\TFS12;

use Doctrine\ORM\Mapping as ORM;

/**
 * MarketHistory
 *
 * @ORM\Table(name="market_history", indexes={@ORM\Index(name="player_id", columns={"player_id", "sale"}), @ORM\Index(name="IDX_2E2C98CB99E6F5DF", columns={"player_id"})})
 * @ORM\Entity
 */
class MarketHistory
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
     * @var bool
     *
     * @ORM\Column(name="sale", type="boolean", nullable=false)
     */
    private $sale = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="itemtype", type="integer", nullable=false, options={"unsigned"=true})
     */
    private $itemtype;

    /**
     * @var int
     *
     * @ORM\Column(name="amount", type="smallint", nullable=false, options={"unsigned"=true})
     */
    private $amount;

    /**
     * @var int
     *
     * @ORM\Column(name="price", type="integer", nullable=false, options={"unsigned"=true})
     */
    private $price = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="expires_at", type="bigint", nullable=false, options={"unsigned"=true})
     */
    private $expiresAt;

    /**
     * @var int
     *
     * @ORM\Column(name="inserted", type="bigint", nullable=false, options={"unsigned"=true})
     */
    private $inserted;

    /**
     * @var bool
     *
     * @ORM\Column(name="state", type="boolean", nullable=false)
     */
    private $state;

    /**
     * @var \Players
     *
     * @ORM\ManyToOne(targetEntity="Players")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="player_id", referencedColumnName="id")
     * })
     */
    private $player;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSale(): ?bool
    {
        return $this->sale;
    }

    public function setSale(bool $sale): self
    {
        $this->sale = $sale;

        return $this;
    }

    public function getItemtype(): ?int
    {
        return $this->itemtype;
    }

    public function setItemtype(int $itemtype): self
    {
        $this->itemtype = $itemtype;

        return $this;
    }

    public function getAmount(): ?int
    {
        return $this->amount;
    }

    public function setAmount(int $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

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

    public function getInserted(): ?int
    {
        return $this->inserted;
    }

    public function setInserted(int $inserted): self
    {
        $this->inserted = $inserted;

        return $this;
    }

    public function getState(): ?bool
    {
        return $this->state;
    }

    public function setState(bool $state): self
    {
        $this->state = $state;

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


}
