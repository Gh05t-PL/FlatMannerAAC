<?php

namespace App\Entity\TFS04;

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
    private $unjustified = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \App\Entity\TFS04\PlayerDeaths
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\TFS04\PlayerDeaths")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="death_id", referencedColumnName="id")
     * })
     */
    private $death;

    /**
     * @return bool
     */
    public function isFinalHit()
    {
        return $this->finalHit;
    }

    /**
     * @param bool $finalHit
     */
    public function setFinalHit($finalHit)
    {
        $this->finalHit = $finalHit;
    }

    /**
     * @return bool
     */
    public function isUnjustified()
    {
        return $this->unjustified;
    }

    /**
     * @param bool $unjustified
     */
    public function setUnjustified($unjustified)
    {
        $this->unjustified = $unjustified;
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
     * @return PlayerDeaths
     */
    public function getDeath()
    {
        return $this->death;
    }

    /**
     * @param PlayerDeaths $death
     */
    public function setDeath($death)
    {
        $this->death = $death;
    }





}
