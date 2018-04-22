<?php

namespace App\Acme\TestBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * GuildRanks
 *
 * @ORM\Table(name="guild_ranks", indexes={@ORM\Index(name="guild_id", columns={"guild_id"})})
 * @ORM\Entity
 */
class GuildRanks
{
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var int
     *
     * @ORM\Column(name="level", type="integer", nullable=false, options={"comment"="1 - leader, 2 - vice leader, 3 - member"})
     */
    private $level;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \App\Acme\TestBundle\Entity\Guilds
     *
     * @ORM\ManyToOne(targetEntity="App\Acme\TestBundle\Entity\Guilds")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="guild_id", referencedColumnName="id")
     * })
     */
    private $guild;

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
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * @param int $level
     */
    public function setLevel($level)
    {
        $this->level = $level;
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

    /**
     * @return Guilds
     */
    public function getGuild()
    {
        return $this->guild;
    }

    /**
     * @param Guilds $guild
     */
    public function setGuild($guild)
    {
        $this->guild = $guild;
    }




}
