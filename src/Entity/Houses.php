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


}
