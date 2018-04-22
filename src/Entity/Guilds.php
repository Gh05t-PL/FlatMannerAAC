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


}
