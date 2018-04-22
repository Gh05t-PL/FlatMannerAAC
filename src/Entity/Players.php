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
    private $name;

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
    private $level = '1';

    /**
     * @var int
     *
     * @ORM\Column(name="vocation", type="integer", nullable=false)
     */
    private $vocation = '0';

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
    private $experience = '0';

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
    private $maglevel = '0';

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
    private $sex = '0';

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
    private $id;

    /**
     * @var \App\Entity\Accounts
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Accounts")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="account_id", referencedColumnName="id")
     * })
     */
    private $account;

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
    public function getGroupId()
    {
        return $this->groupId;
    }

    /**
     * @param int $groupId
     */
    public function setGroupId($groupId)
    {
        $this->groupId = $groupId;
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
    public function getVocation()
    {
        return $this->vocation;
    }

    /**
     * @param int $vocation
     */
    public function setVocation($vocation)
    {
        $this->vocation = $vocation;
    }

    /**
     * @return int
     */
    public function getHealth()
    {
        return $this->health;
    }

    /**
     * @param int $health
     */
    public function setHealth($health)
    {
        $this->health = $health;
    }

    /**
     * @return int
     */
    public function getHealthmax()
    {
        return $this->healthmax;
    }

    /**
     * @param int $healthmax
     */
    public function setHealthmax($healthmax)
    {
        $this->healthmax = $healthmax;
    }

    /**
     * @return int
     */
    public function getExperience()
    {
        return $this->experience;
    }

    /**
     * @param int $experience
     */
    public function setExperience($experience)
    {
        $this->experience = $experience;
    }

    /**
     * @return int
     */
    public function getLookbody()
    {
        return $this->lookbody;
    }

    /**
     * @param int $lookbody
     */
    public function setLookbody($lookbody)
    {
        $this->lookbody = $lookbody;
    }

    /**
     * @return int
     */
    public function getLookfeet()
    {
        return $this->lookfeet;
    }

    /**
     * @param int $lookfeet
     */
    public function setLookfeet($lookfeet)
    {
        $this->lookfeet = $lookfeet;
    }

    /**
     * @return int
     */
    public function getLookhead()
    {
        return $this->lookhead;
    }

    /**
     * @param int $lookhead
     */
    public function setLookhead($lookhead)
    {
        $this->lookhead = $lookhead;
    }

    /**
     * @return int
     */
    public function getLooklegs()
    {
        return $this->looklegs;
    }

    /**
     * @param int $looklegs
     */
    public function setLooklegs($looklegs)
    {
        $this->looklegs = $looklegs;
    }

    /**
     * @return int
     */
    public function getLooktype()
    {
        return $this->looktype;
    }

    /**
     * @param int $looktype
     */
    public function setLooktype($looktype)
    {
        $this->looktype = $looktype;
    }

    /**
     * @return int
     */
    public function getLookaddons()
    {
        return $this->lookaddons;
    }

    /**
     * @param int $lookaddons
     */
    public function setLookaddons($lookaddons)
    {
        $this->lookaddons = $lookaddons;
    }

    /**
     * @return int
     */
    public function getMaglevel()
    {
        return $this->maglevel;
    }

    /**
     * @param int $maglevel
     */
    public function setMaglevel($maglevel)
    {
        $this->maglevel = $maglevel;
    }

    /**
     * @return int
     */
    public function getMana()
    {
        return $this->mana;
    }

    /**
     * @param int $mana
     */
    public function setMana($mana)
    {
        $this->mana = $mana;
    }

    /**
     * @return int
     */
    public function getManamax()
    {
        return $this->manamax;
    }

    /**
     * @param int $manamax
     */
    public function setManamax($manamax)
    {
        $this->manamax = $manamax;
    }

    /**
     * @return int
     */
    public function getManaspent()
    {
        return $this->manaspent;
    }

    /**
     * @param int $manaspent
     */
    public function setManaspent($manaspent)
    {
        $this->manaspent = $manaspent;
    }

    /**
     * @return int
     */
    public function getSoul()
    {
        return $this->soul;
    }

    /**
     * @param int $soul
     */
    public function setSoul($soul)
    {
        $this->soul = $soul;
    }

    /**
     * @return int
     */
    public function getTownId()
    {
        return $this->townId;
    }

    /**
     * @param int $townId
     */
    public function setTownId($townId)
    {
        $this->townId = $townId;
    }

    /**
     * @return int
     */
    public function getPosx()
    {
        return $this->posx;
    }

    /**
     * @param int $posx
     */
    public function setPosx($posx)
    {
        $this->posx = $posx;
    }

    /**
     * @return int
     */
    public function getPosy()
    {
        return $this->posy;
    }

    /**
     * @param int $posy
     */
    public function setPosy($posy)
    {
        $this->posy = $posy;
    }

    /**
     * @return int
     */
    public function getPosz()
    {
        return $this->posz;
    }

    /**
     * @param int $posz
     */
    public function setPosz($posz)
    {
        $this->posz = $posz;
    }

    /**
     * @return string
     */
    public function getConditions()
    {
        return $this->conditions;
    }

    /**
     * @param string $conditions
     */
    public function setConditions($conditions)
    {
        $this->conditions = $conditions;
    }

    /**
     * @return int
     */
    public function getCap()
    {
        return $this->cap;
    }

    /**
     * @param int $cap
     */
    public function setCap($cap)
    {
        $this->cap = $cap;
    }

    /**
     * @return int
     */
    public function getSex()
    {
        return $this->sex;
    }

    /**
     * @param int $sex
     */
    public function setSex($sex)
    {
        $this->sex = $sex;
    }

    /**
     * @return int
     */
    public function getLastlogin()
    {
        return $this->lastlogin;
    }

    /**
     * @param int $lastlogin
     */
    public function setLastlogin($lastlogin)
    {
        $this->lastlogin = $lastlogin;
    }

    /**
     * @return int
     */
    public function getLastip()
    {
        return $this->lastip;
    }

    /**
     * @param int $lastip
     */
    public function setLastip($lastip)
    {
        $this->lastip = $lastip;
    }

    /**
     * @return bool
     */
    public function isSave()
    {
        return $this->save;
    }

    /**
     * @param bool $save
     */
    public function setSave($save)
    {
        $this->save = $save;
    }

    /**
     * @return bool
     */
    public function isSkull()
    {
        return $this->skull;
    }

    /**
     * @param bool $skull
     */
    public function setSkull($skull)
    {
        $this->skull = $skull;
    }

    /**
     * @return int
     */
    public function getSkulltime()
    {
        return $this->skulltime;
    }

    /**
     * @param int $skulltime
     */
    public function setSkulltime($skulltime)
    {
        $this->skulltime = $skulltime;
    }

    /**
     * @return int
     */
    public function getRankId()
    {
        return $this->rankId;
    }

    /**
     * @param int $rankId
     */
    public function setRankId($rankId)
    {
        $this->rankId = $rankId;
    }

    /**
     * @return string
     */
    public function getGuildnick()
    {
        return $this->guildnick;
    }

    /**
     * @param string $guildnick
     */
    public function setGuildnick($guildnick)
    {
        $this->guildnick = $guildnick;
    }

    /**
     * @return int
     */
    public function getLastlogout()
    {
        return $this->lastlogout;
    }

    /**
     * @param int $lastlogout
     */
    public function setLastlogout($lastlogout)
    {
        $this->lastlogout = $lastlogout;
    }

    /**
     * @return bool
     */
    public function isBlessings()
    {
        return $this->blessings;
    }

    /**
     * @param bool $blessings
     */
    public function setBlessings($blessings)
    {
        $this->blessings = $blessings;
    }

    /**
     * @return int
     */
    public function getBalance()
    {
        return $this->balance;
    }

    /**
     * @param int $balance
     */
    public function setBalance($balance)
    {
        $this->balance = $balance;
    }

    /**
     * @return int
     */
    public function getStamina()
    {
        return $this->stamina;
    }

    /**
     * @param int $stamina
     */
    public function setStamina($stamina)
    {
        $this->stamina = $stamina;
    }

    /**
     * @return int
     */
    public function getDirection()
    {
        return $this->direction;
    }

    /**
     * @param int $direction
     */
    public function setDirection($direction)
    {
        $this->direction = $direction;
    }

    /**
     * @return int
     */
    public function getLossExperience()
    {
        return $this->lossExperience;
    }

    /**
     * @param int $lossExperience
     */
    public function setLossExperience($lossExperience)
    {
        $this->lossExperience = $lossExperience;
    }

    /**
     * @return int
     */
    public function getLossMana()
    {
        return $this->lossMana;
    }

    /**
     * @param int $lossMana
     */
    public function setLossMana($lossMana)
    {
        $this->lossMana = $lossMana;
    }

    /**
     * @return int
     */
    public function getLossSkills()
    {
        return $this->lossSkills;
    }

    /**
     * @param int $lossSkills
     */
    public function setLossSkills($lossSkills)
    {
        $this->lossSkills = $lossSkills;
    }

    /**
     * @return int
     */
    public function getLossContainers()
    {
        return $this->lossContainers;
    }

    /**
     * @param int $lossContainers
     */
    public function setLossContainers($lossContainers)
    {
        $this->lossContainers = $lossContainers;
    }

    /**
     * @return int
     */
    public function getLossItems()
    {
        return $this->lossItems;
    }

    /**
     * @param int $lossItems
     */
    public function setLossItems($lossItems)
    {
        $this->lossItems = $lossItems;
    }

    /**
     * @return int
     */
    public function getPremend()
    {
        return $this->premend;
    }

    /**
     * @param int $premend
     */
    public function setPremend($premend)
    {
        $this->premend = $premend;
    }

    /**
     * @return bool
     */
    public function isOnline()
    {
        return $this->online;
    }

    /**
     * @param bool $online
     */
    public function setOnline($online)
    {
        $this->online = $online;
    }

    /**
     * @return int
     */
    public function getMarriage()
    {
        return $this->marriage;
    }

    /**
     * @param int $marriage
     */
    public function setMarriage($marriage)
    {
        $this->marriage = $marriage;
    }

    /**
     * @return int
     */
    public function getPromotion()
    {
        return $this->promotion;
    }

    /**
     * @param int $promotion
     */
    public function setPromotion($promotion)
    {
        $this->promotion = $promotion;
    }

    /**
     * @return bool
     */
    public function isDeleted()
    {
        return $this->deleted;
    }

    /**
     * @param bool $deleted
     */
    public function setDeleted($deleted)
    {
        $this->deleted = $deleted;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
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
     * @return Accounts
     */
    public function getAccount()
    {
        return $this->account;
    }

    /**
     * @param Accounts $account
     */
    public function setAccount($account)
    {
        $this->account = $account;
    }









}
