<?php

namespace App\Acme\TestBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Houses
 *
 * @ORM\Table(name="houses", uniqueConstraints={@ORM\UniqueConstraint(name="id", columns={"id", "world_id"})})
 * @ORM\Entity
 */
class Houses
{
    /**
     * @var bool
     *
     * @ORM\Column(name="world_id", type="boolean", nullable=false)
     */
    private $worldId = '0';

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
     * @var int
     *
     * @ORM\Column(name="lastwarning", type="integer", nullable=false, options={"unsigned"=true})
     */
    private $lastwarning = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var int
     *
     * @ORM\Column(name="town", type="integer", nullable=false, options={"unsigned"=true})
     */
    private $town = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="size", type="integer", nullable=false, options={"unsigned"=true})
     */
    private $size = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="price", type="integer", nullable=false, options={"unsigned"=true})
     */
    private $price = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="rent", type="integer", nullable=false, options={"unsigned"=true})
     */
    private $rent = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="doors", type="integer", nullable=false, options={"unsigned"=true})
     */
    private $doors = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="beds", type="integer", nullable=false, options={"unsigned"=true})
     */
    private $beds = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="tiles", type="integer", nullable=false, options={"unsigned"=true})
     */
    private $tiles = '0';

    /**
     * @var bool
     *
     * @ORM\Column(name="guild", type="boolean", nullable=false)
     */
    private $guild = '0';

    /**
     * @var bool
     *
     * @ORM\Column(name="clear", type="boolean", nullable=false)
     */
    private $clear = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @return bool
     */
    public function isWorldId()
    {
        return $this->worldId;
    }

    /**
     * @param bool $worldId
     */
    public function setWorldId($worldId)
    {
        $this->worldId = $worldId;
    }

    /**
     * @return int
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * @param int $owner
     */
    public function setOwner($owner)
    {
        $this->owner = $owner;
    }

    /**
     * @return int
     */
    public function getPaid()
    {
        return $this->paid;
    }

    /**
     * @param int $paid
     */
    public function setPaid($paid)
    {
        $this->paid = $paid;
    }

    /**
     * @return int
     */
    public function getWarnings()
    {
        return $this->warnings;
    }

    /**
     * @param int $warnings
     */
    public function setWarnings($warnings)
    {
        $this->warnings = $warnings;
    }

    /**
     * @return int
     */
    public function getLastwarning()
    {
        return $this->lastwarning;
    }

    /**
     * @param int $lastwarning
     */
    public function setLastwarning($lastwarning)
    {
        $this->lastwarning = $lastwarning;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return int
     */
    public function getTown()
    {
        return $this->town;
    }

    /**
     * @param int $town
     */
    public function setTown($town)
    {
        $this->town = $town;
    }

    /**
     * @return int
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @param int $size
     */
    public function setSize($size)
    {
        $this->size = $size;
    }

    /**
     * @return int
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param int $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

    /**
     * @return int
     */
    public function getRent()
    {
        return $this->rent;
    }

    /**
     * @param int $rent
     */
    public function setRent($rent)
    {
        $this->rent = $rent;
    }

    /**
     * @return int
     */
    public function getDoors()
    {
        return $this->doors;
    }

    /**
     * @param int $doors
     */
    public function setDoors($doors)
    {
        $this->doors = $doors;
    }

    /**
     * @return int
     */
    public function getBeds()
    {
        return $this->beds;
    }

    /**
     * @param int $beds
     */
    public function setBeds($beds)
    {
        $this->beds = $beds;
    }

    /**
     * @return int
     */
    public function getTiles()
    {
        return $this->tiles;
    }

    /**
     * @param int $tiles
     */
    public function setTiles($tiles)
    {
        $this->tiles = $tiles;
    }

    /**
     * @return bool
     */
    public function isGuild()
    {
        return $this->guild;
    }

    /**
     * @param bool $guild
     */
    public function setGuild($guild)
    {
        $this->guild = $guild;
    }

    /**
     * @return bool
     */
    public function isClear()
    {
        return $this->clear;
    }

    /**
     * @param bool $clear
     */
    public function setClear($clear)
    {
        $this->clear = $clear;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }





}
