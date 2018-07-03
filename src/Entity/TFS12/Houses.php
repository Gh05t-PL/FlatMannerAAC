<?php

namespace App\Entity\TFS12;

use Doctrine\ORM\Mapping as ORM;

/**
 * Houses
 *
 * @ORM\Table(name="houses", indexes={@ORM\Index(name="owner", columns={"owner"}), @ORM\Index(name="town_id", columns={"town_id"})})
 * @ORM\Entity
 */
class Houses
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
     * @ORM\Column(name="owner", type="integer", nullable=false)
     */
    private $owner;

    /**
     * @var int
     *
     * @ORM\Column(name="paid", type="integer", nullable=false, options={"unsigned"=true})
     */
    private $paid = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="warnings", type="integer", nullable=false)
     */
    private $warnings = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var int
     *
     * @ORM\Column(name="rent", type="integer", nullable=false)
     */
    private $rent = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="town_id", type="integer", nullable=false)
     */
    private $townId = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="bid", type="integer", nullable=false)
     */
    private $bid = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="bid_end", type="integer", nullable=false)
     */
    private $bidEnd = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="last_bid", type="integer", nullable=false)
     */
    private $lastBid = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="highest_bidder", type="integer", nullable=false)
     */
    private $highestBidder = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="size", type="integer", nullable=false)
     */
    private $size = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="beds", type="integer", nullable=false)
     */
    private $beds = '0';

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOwner(): ?int
    {
        return $this->owner;
    }

    public function setOwner(int $owner): self
    {
        $this->owner = $owner;

        return $this;
    }

    public function getPaid(): ?int
    {
        return $this->paid;
    }

    public function setPaid(int $paid): self
    {
        $this->paid = $paid;

        return $this;
    }

    public function getWarnings(): ?int
    {
        return $this->warnings;
    }

    public function setWarnings(int $warnings): self
    {
        $this->warnings = $warnings;

        return $this;
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

    public function getRent(): ?int
    {
        return $this->rent;
    }

    public function setRent(int $rent): self
    {
        $this->rent = $rent;

        return $this;
    }

    public function getTownId(): ?int
    {
        return $this->townId;
    }

    public function setTownId(int $townId): self
    {
        $this->townId = $townId;

        return $this;
    }

    public function getBid(): ?int
    {
        return $this->bid;
    }

    public function setBid(int $bid): self
    {
        $this->bid = $bid;

        return $this;
    }

    public function getBidEnd(): ?int
    {
        return $this->bidEnd;
    }

    public function setBidEnd(int $bidEnd): self
    {
        $this->bidEnd = $bidEnd;

        return $this;
    }

    public function getLastBid(): ?int
    {
        return $this->lastBid;
    }

    public function setLastBid(int $lastBid): self
    {
        $this->lastBid = $lastBid;

        return $this;
    }

    public function getHighestBidder(): ?int
    {
        return $this->highestBidder;
    }

    public function setHighestBidder(int $highestBidder): self
    {
        $this->highestBidder = $highestBidder;

        return $this;
    }

    public function getSize(): ?int
    {
        return $this->size;
    }

    public function setSize(int $size): self
    {
        $this->size = $size;

        return $this;
    }

    public function getBeds(): ?int
    {
        return $this->beds;
    }

    public function setBeds(int $beds): self
    {
        $this->beds = $beds;

        return $this;
    }


}
