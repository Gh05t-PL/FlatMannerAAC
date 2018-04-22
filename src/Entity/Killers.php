<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Killers
 *
 * @ORM\Table(name="killers", indexes={@ORM\Index(name="death_id", columns={"death_id"})})
 * @ORM\Entity
 */
class Killers
{
    /**
     * @var bool
     *
     * @ORM\Column(name="final_hit", type="boolean", nullable=false)
     */
    private $finalHit = '0';

    /**
     * @var bool
     *
     * @ORM\Column(name="unjustified", type="boolean", nullable=false)
     */
    public $unjustified = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    public $id;

    /**
     * @var \App\Entity\PlayerDeaths
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\PlayerDeaths")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="death_id", referencedColumnName="id")
     * })
     */
    public $death;


}
