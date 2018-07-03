<?php

namespace App\Entity\TFS12;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Guilds
 *
 * @ORM\Table(name="guilds", uniqueConstraints={@ORM\UniqueConstraint(name="name", columns={"name"}), @ORM\UniqueConstraint(name="ownerid", columns={"ownerid"})})
 * @ORM\Entity
 */
class Guilds
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
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var int
     *
     * @ORM\Column(name="creationdata", type="integer", nullable=false)
     */
    private $creationdata;

    /**
     * @var string
     *
     * @ORM\Column(name="motd", type="string", length=255, nullable=false)
     */
    private $motd = '';

    /**
     * @var \Players
     *
     * @ORM\ManyToOne(targetEntity="Players")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ownerid", referencedColumnName="id")
     * })
     */
    private $ownerid;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Players", mappedBy="guild")
     */
    private $player;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->player = new \Doctrine\Common\Collections\ArrayCollection();
    }

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

    public function getCreationdata(): ?int
    {
        return $this->creationdata;
    }

    public function setCreationdata(int $creationdata): self
    {
        $this->creationdata = $creationdata;

        return $this;
    }

    public function getMotd(): ?string
    {
        return $this->motd;
    }

    public function setMotd(string $motd): self
    {
        $this->motd = $motd;

        return $this;
    }

    public function getOwnerid(): ?Players
    {
        return $this->ownerid;
    }

    public function setOwnerid(?Players $ownerid): self
    {
        $this->ownerid = $ownerid;

        return $this;
    }

    /**
     * @return Collection|Players[]
     */
    public function getPlayer(): Collection
    {
        return $this->player;
    }

    public function addPlayer(Players $player): self
    {
        if (!$this->player->contains($player)) {
            $this->player[] = $player;
            $player->addGuild($this);
        }

        return $this;
    }

    public function removePlayer(Players $player): self
    {
        if ($this->player->contains($player)) {
            $this->player->removeElement($player);
            $player->removeGuild($this);
        }

        return $this;
    }

}
