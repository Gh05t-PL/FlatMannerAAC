<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Players
 *
 * @ORM\Table(name="players", uniqueConstraints={@ORM\UniqueConstraint(name="name", columns={"name", "deleted"})}, indexes={@ORM\Index(name="account_id", columns={"account_id"}), @ORM\Index(name="group_id", columns={"group_id"}), @ORM\Index(name="online", columns={"online"}), @ORM\Index(name="deleted", columns={"deleted"})})
 * @ORM\Entity
 */
class Players
{
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    public $name;

    /**
     * @var bool
     *
     * @ORM\Column(name="world_id", type="boolean", nullable=false)
     */
    private $worldId = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="group_id", type="integer", nullable=false, options={"default"="1"})
     */
    private $groupId = '1';

    /**
     * @var int
     *
     * @ORM\Column(name="level", type="integer", nullable=false, options={"default"="1"})
     */
    public $level = '1';

    /**
     * @var int
     *
     * @ORM\Column(name="vocation", type="integer", nullable=false)
     */
    public $vocation = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="health", type="integer", nullable=false, options={"default"="150"})
     */
    private $health = '150';

    /**
     * @var int
     *
     * @ORM\Column(name="healthmax", type="integer", nullable=false, options={"default"="150"})
     */
    private $healthmax = '150';

    /**
     * @var int
     *
     * @ORM\Column(name="experience", type="bigint", nullable=false)
     */
    public $experience = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="lookbody", type="integer", nullable=false)
     */
    private $lookbody = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="lookfeet", type="integer", nullable=false)
     */
    private $lookfeet = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="lookhead", type="integer", nullable=false)
     */
    private $lookhead = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="looklegs", type="integer", nullable=false)
     */
    private $looklegs = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="looktype", type="integer", nullable=false, options={"default"="136"})
     */
    private $looktype = '136';

    /**
     * @var int
     *
     * @ORM\Column(name="lookaddons", type="integer", nullable=false)
     */
    private $lookaddons = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="maglevel", type="integer", nullable=false)
     */
    public $maglevel = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="mana", type="integer", nullable=false)
     */
    private $mana = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="manamax", type="integer", nullable=false)
     */
    private $manamax = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="manaspent", type="integer", nullable=false)
     */
    private $manaspent = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="soul", type="integer", nullable=false, options={"unsigned"=true})
     */
    private $soul = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="town_id", type="integer", nullable=false)
     */
    private $townId = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="posx", type="integer", nullable=false)
     */
    private $posx = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="posy", type="integer", nullable=false)
     */
    private $posy = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="posz", type="integer", nullable=false)
     */
    private $posz = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="conditions", type="blob", length=65535, nullable=false)
     */
    private $conditions = '';

    /**
     * @var int
     *
     * @ORM\Column(name="cap", type="integer", nullable=false)
     */
    private $cap = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="sex", type="integer", nullable=false)
     */
    public $sex = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="lastlogin", type="bigint", nullable=false, options={"unsigned"=true})
     */
    private $lastlogin = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="lastip", type="integer", nullable=false, options={"unsigned"=true})
     */
    private $lastip = '0';

    /**
     * @var bool
     *
     * @ORM\Column(name="save", type="boolean", nullable=false, options={"default"="1"})
     */
    private $save = '1';

    /**
     * @var bool
     *
     * @ORM\Column(name="skull", type="boolean", nullable=false)
     */
    private $skull = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="skulltime", type="integer", nullable=false)
     */
    private $skulltime = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="rank_id", type="integer", nullable=false)
     */
    private $rankId = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="guildnick", type="string", length=255, nullable=false)
     */
    private $guildnick = '';

    /**
     * @var int
     *
     * @ORM\Column(name="lastlogout", type="bigint", nullable=false, options={"unsigned"=true})
     */
    private $lastlogout = '0';

    /**
     * @var bool
     *
     * @ORM\Column(name="blessings", type="boolean", nullable=false)
     */
    private $blessings = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="balance", type="bigint", nullable=false)
     */
    private $balance = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="stamina", type="bigint", nullable=false, options={"default"="151200000","comment"="stored in miliseconds"})
     */
    private $stamina = '151200000';

    /**
     * @var int
     *
     * @ORM\Column(name="direction", type="integer", nullable=false, options={"default"="2"})
     */
    private $direction = '2';

    /**
     * @var int
     *
     * @ORM\Column(name="loss_experience", type="integer", nullable=false, options={"default"="100"})
     */
    private $lossExperience = '100';

    /**
     * @var int
     *
     * @ORM\Column(name="loss_mana", type="integer", nullable=false, options={"default"="100"})
     */
    private $lossMana = '100';

    /**
     * @var int
     *
     * @ORM\Column(name="loss_skills", type="integer", nullable=false, options={"default"="100"})
     */
    private $lossSkills = '100';

    /**
     * @var int
     *
     * @ORM\Column(name="loss_containers", type="integer", nullable=false, options={"default"="100"})
     */
    private $lossContainers = '100';

    /**
     * @var int
     *
     * @ORM\Column(name="loss_items", type="integer", nullable=false, options={"default"="100"})
     */
    private $lossItems = '100';

    /**
     * @var int
     *
     * @ORM\Column(name="premend", type="integer", nullable=false, options={"comment"="NOT IN USE BY THE SERVER"})
     */
    private $premend = '0';

    /**
     * @var bool
     *
     * @ORM\Column(name="online", type="boolean", nullable=false)
     */
    private $online = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="marriage", type="integer", nullable=false, options={"unsigned"=true})
     */
    private $marriage = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="promotion", type="integer", nullable=false)
     */
    private $promotion = '0';

    /**
     * @var bool
     *
     * @ORM\Column(name="deleted", type="boolean", nullable=false)
     */
    private $deleted = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=false)
     */
    private $description = '';

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    public $id;

    /**
     * @var \App\Entity\Accounts
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Accounts")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="account_id", referencedColumnName="id")
     * })
     */
    public $account;


}
