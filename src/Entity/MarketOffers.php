<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MarketOffers
 *
 * @ORM\Table(name="market_offers", indexes={@ORM\Index(name="sale", columns={"sale", "itemtype"}), @ORM\Index(name="created", columns={"created"}), @ORM\Index(name="player_id", columns={"player_id"})})
 * @ORM\Entity
 */
class MarketOffers
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
     * @ORM\Column(name="created", type="bigint", nullable=false, options={"unsigned"=true})
     */
    private $created;

    /**
     * @var bool
     *
     * @ORM\Column(name="anonymous", type="boolean", nullable=false)
     */
    private $anonymous = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="price", type="integer", nullable=false, options={"unsigned"=true})
     */
    private $price = '0';

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

    public function getCreated(): ?int
    {
        return $this->created;
    }

    public function setCreated(int $created): self
    {
        $this->created = $created;

        return $this;
    }

    public function getAnonymous(): ?bool
    {
        return $this->anonymous;
    }

    public function setAnonymous(bool $anonymous): self
    {
        $this->anonymous = $anonymous;

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
