<?php

namespace App\Acme\TestBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Guilds
 *
 * @ORM\Table(name="guilds", uniqueConstraints={@ORM\UniqueConstraint(name="name", columns={"name", "world_id"})})
 * @ORM\Entity
 */
class Guilds
{
    /**
     * @var bool
     *
     * @ORM\Column(name="world_id", type="boolean", nullable=false)
     */
    private $worldId = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var int
     *
     * @ORM\Column(name="ownerid", type="integer", nullable=false)
     */
    private $ownerid;

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
    private $motd;

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
    public function getOwnerid()
    {
        return $this->ownerid;
    }

    /**
     * @param int $ownerid
     */
    public function setOwnerid($ownerid)
    {
        $this->ownerid = $ownerid;
    }

    /**
     * @return int
     */
    public function getCreationdata()
    {
        return $this->creationdata;
    }

    /**
     * @param int $creationdata
     */
    public function setCreationdata($creationdata)
    {
        $this->creationdata = $creationdata;
    }

    /**
     * @return string
     */
    public function getMotd()
    {
        return $this->motd;
    }

    /**
     * @param string $motd
     */
    public function setMotd($motd)
    {
        $this->motd = $motd;
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
