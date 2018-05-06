<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Players
 *
 * @ORM\Table(name="players", uniqueConstraints={@ORM\UniqueConstraint(name="name", columns={"name"})}, indexes={@ORM\Index(name="account_id", columns={"account_id"}), @ORM\Index(name="vocation", columns={"vocation"})})
 * @ORM\Entity
 */
class Players
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
     * @ORM\Column(name="manaspent", type="integer", nullable=false, options={"unsigned"=true})
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
     * @ORM\Column(name="onlinetime", type="integer", nullable=false)
     */
    private $onlinetime = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="deletion", type="bigint", nullable=false)
     */
    private $deletion = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="balance", type="bigint", nullable=false, options={"unsigned"=true})
     */
    private $balance = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="offlinetraining_time", type="smallint", nullable=false, options={"default"="43200","unsigned"=true})
     */
    private $offlinetrainingTime = '43200';

    /**
     * @var int
     *
     * @ORM\Column(name="offlinetraining_skill", type="integer", nullable=false, options={"default"="-1"})
     */
    private $offlinetrainingSkill = '-1';

    /**
     * @var int
     *
     * @ORM\Column(name="stamina", type="smallint", nullable=false, options={"default"="2520","unsigned"=true})
     */
    private $stamina = '2520';

    /**
     * @var int
     *
     * @ORM\Column(name="skill_fist", type="integer", nullable=false, options={"default"="10","unsigned"=true})
     */
    private $skillFist = '10';

    /**
     * @var int
     *
     * @ORM\Column(name="skill_fist_tries", type="bigint", nullable=false, options={"unsigned"=true})
     */
    private $skillFistTries = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="skill_club", type="integer", nullable=false, options={"default"="10","unsigned"=true})
     */
    private $skillClub = '10';

    /**
     * @var int
     *
     * @ORM\Column(name="skill_club_tries", type="bigint", nullable=false, options={"unsigned"=true})
     */
    private $skillClubTries = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="skill_sword", type="integer", nullable=false, options={"default"="10","unsigned"=true})
     */
    private $skillSword = '10';

    /**
     * @var int
     *
     * @ORM\Column(name="skill_sword_tries", type="bigint", nullable=false, options={"unsigned"=true})
     */
    private $skillSwordTries = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="skill_axe", type="integer", nullable=false, options={"default"="10","unsigned"=true})
     */
    private $skillAxe = '10';

    /**
     * @var int
     *
     * @ORM\Column(name="skill_axe_tries", type="bigint", nullable=false, options={"unsigned"=true})
     */
    private $skillAxeTries = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="skill_dist", type="integer", nullable=false, options={"default"="10","unsigned"=true})
     */
    private $skillDist = '10';

    /**
     * @var int
     *
     * @ORM\Column(name="skill_dist_tries", type="bigint", nullable=false, options={"unsigned"=true})
     */
    private $skillDistTries = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="skill_shielding", type="integer", nullable=false, options={"default"="10","unsigned"=true})
     */
    private $skillShielding = '10';

    /**
     * @var int
     *
     * @ORM\Column(name="skill_shielding_tries", type="bigint", nullable=false, options={"unsigned"=true})
     */
    private $skillShieldingTries = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="skill_fishing", type="integer", nullable=false, options={"default"="10","unsigned"=true})
     */
    private $skillFishing = '10';

    /**
     * @var int
     *
     * @ORM\Column(name="skill_fishing_tries", type="bigint", nullable=false, options={"unsigned"=true})
     */
    private $skillFishingTries = '0';

    /**
     * @var \Accounts
     *
     * @ORM\ManyToOne(targetEntity="Accounts")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="account_id", referencedColumnName="id")
     * })
     */
    private $account;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Guilds", inversedBy="player")
     * @ORM\JoinTable(name="guild_invites",
     *   joinColumns={
     *     @ORM\JoinColumn(name="player_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="guild_id", referencedColumnName="id")
     *   }
     * )
     */
    private $guild;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->guild = new \Doctrine\Common\Collections\ArrayCollection();
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

    public function getGroupId(): ?int
    {
        return $this->groupId;
    }

    public function setGroupId(int $groupId): self
    {
        $this->groupId = $groupId;

        return $this;
    }

    public function getLevel(): ?int
    {
        return $this->level;
    }

    public function setLevel(int $level): self
    {
        $this->level = $level;

        return $this;
    }

    public function getVocation(): ?int
    {
        return $this->vocation;
    }

    public function setVocation(int $vocation): self
    {
        $this->vocation = $vocation;

        return $this;
    }

    public function getHealth(): ?int
    {
        return $this->health;
    }

    public function setHealth(int $health): self
    {
        $this->health = $health;

        return $this;
    }

    public function getHealthmax(): ?int
    {
        return $this->healthmax;
    }

    public function setHealthmax(int $healthmax): self
    {
        $this->healthmax = $healthmax;

        return $this;
    }

    public function getExperience(): ?int
    {
        return $this->experience;
    }

    public function setExperience(int $experience): self
    {
        $this->experience = $experience;

        return $this;
    }

    public function getLookbody(): ?int
    {
        return $this->lookbody;
    }

    public function setLookbody(int $lookbody): self
    {
        $this->lookbody = $lookbody;

        return $this;
    }

    public function getLookfeet(): ?int
    {
        return $this->lookfeet;
    }

    public function setLookfeet(int $lookfeet): self
    {
        $this->lookfeet = $lookfeet;

        return $this;
    }

    public function getLookhead(): ?int
    {
        return $this->lookhead;
    }

    public function setLookhead(int $lookhead): self
    {
        $this->lookhead = $lookhead;

        return $this;
    }

    public function getLooklegs(): ?int
    {
        return $this->looklegs;
    }

    public function setLooklegs(int $looklegs): self
    {
        $this->looklegs = $looklegs;

        return $this;
    }

    public function getLooktype(): ?int
    {
        return $this->looktype;
    }

    public function setLooktype(int $looktype): self
    {
        $this->looktype = $looktype;

        return $this;
    }

    public function getLookaddons(): ?int
    {
        return $this->lookaddons;
    }

    public function setLookaddons(int $lookaddons): self
    {
        $this->lookaddons = $lookaddons;

        return $this;
    }

    public function getMaglevel(): ?int
    {
        return $this->maglevel;
    }

    public function setMaglevel(int $maglevel): self
    {
        $this->maglevel = $maglevel;

        return $this;
    }

    public function getMana(): ?int
    {
        return $this->mana;
    }

    public function setMana(int $mana): self
    {
        $this->mana = $mana;

        return $this;
    }

    public function getManamax(): ?int
    {
        return $this->manamax;
    }

    public function setManamax(int $manamax): self
    {
        $this->manamax = $manamax;

        return $this;
    }

    public function getManaspent(): ?int
    {
        return $this->manaspent;
    }

    public function setManaspent(int $manaspent): self
    {
        $this->manaspent = $manaspent;

        return $this;
    }

    public function getSoul(): ?int
    {
        return $this->soul;
    }

    public function setSoul(int $soul): self
    {
        $this->soul = $soul;

        return $this;
    }

    public function getTownId(): ?int
    {
        return $this->townId;
    }

    public function setTownId(int $townId): self
    {
        $this->townId = $townId;

        return $this;
    }

    public function getPosx(): ?int
    {
        return $this->posx;
    }

    public function setPosx(int $posx): self
    {
        $this->posx = $posx;

        return $this;
    }

    public function getPosy(): ?int
    {
        return $this->posy;
    }

    public function setPosy(int $posy): self
    {
        $this->posy = $posy;

        return $this;
    }

    public function getPosz(): ?int
    {
        return $this->posz;
    }

    public function setPosz(int $posz): self
    {
        $this->posz = $posz;

        return $this;
    }

    public function getConditions()
    {
        return $this->conditions;
    }

    public function setConditions($conditions): self
    {
        $this->conditions = $conditions;

        return $this;
    }

    public function getCap(): ?int
    {
        return $this->cap;
    }

    public function setCap(int $cap): self
    {
        $this->cap = $cap;

        return $this;
    }

    public function getSex(): ?int
    {
        return $this->sex;
    }

    public function setSex(int $sex): self
    {
        $this->sex = $sex;

        return $this;
    }

    public function getLastlogin(): ?int
    {
        return $this->lastlogin;
    }

    public function setLastlogin(int $lastlogin): self
    {
        $this->lastlogin = $lastlogin;

        return $this;
    }

    public function getLastip(): ?int
    {
        return $this->lastip;
    }

    public function setLastip(int $lastip): self
    {
        $this->lastip = $lastip;

        return $this;
    }

    public function getSave(): ?bool
    {
        return $this->save;
    }

    public function setSave(bool $save): self
    {
        $this->save = $save;

        return $this;
    }

    public function getSkull(): ?bool
    {
        return $this->skull;
    }

    public function setSkull(bool $skull): self
    {
        $this->skull = $skull;

        return $this;
    }

    public function getSkulltime(): ?int
    {
        return $this->skulltime;
    }

    public function setSkulltime(int $skulltime): self
    {
        $this->skulltime = $skulltime;

        return $this;
    }

    public function getLastlogout(): ?int
    {
        return $this->lastlogout;
    }

    public function setLastlogout(int $lastlogout): self
    {
        $this->lastlogout = $lastlogout;

        return $this;
    }

    public function getBlessings(): ?bool
    {
        return $this->blessings;
    }

    public function setBlessings(bool $blessings): self
    {
        $this->blessings = $blessings;

        return $this;
    }

    public function getOnlinetime(): ?int
    {
        return $this->onlinetime;
    }

    public function setOnlinetime(int $onlinetime): self
    {
        $this->onlinetime = $onlinetime;

        return $this;
    }

    public function getDeletion(): ?int
    {
        return $this->deletion;
    }

    public function setDeletion(int $deletion): self
    {
        $this->deletion = $deletion;

        return $this;
    }

    public function getBalance(): ?int
    {
        return $this->balance;
    }

    public function setBalance(int $balance): self
    {
        $this->balance = $balance;

        return $this;
    }

    public function getOfflinetrainingTime(): ?int
    {
        return $this->offlinetrainingTime;
    }

    public function setOfflinetrainingTime(int $offlinetrainingTime): self
    {
        $this->offlinetrainingTime = $offlinetrainingTime;

        return $this;
    }

    public function getOfflinetrainingSkill(): ?int
    {
        return $this->offlinetrainingSkill;
    }

    public function setOfflinetrainingSkill(int $offlinetrainingSkill): self
    {
        $this->offlinetrainingSkill = $offlinetrainingSkill;

        return $this;
    }

    public function getStamina(): ?int
    {
        return $this->stamina;
    }

    public function setStamina(int $stamina): self
    {
        $this->stamina = $stamina;

        return $this;
    }

    public function getSkillFist(): ?int
    {
        return $this->skillFist;
    }

    public function setSkillFist(int $skillFist): self
    {
        $this->skillFist = $skillFist;

        return $this;
    }

    public function getSkillFistTries(): ?int
    {
        return $this->skillFistTries;
    }

    public function setSkillFistTries(int $skillFistTries): self
    {
        $this->skillFistTries = $skillFistTries;

        return $this;
    }

    public function getSkillClub(): ?int
    {
        return $this->skillClub;
    }

    public function setSkillClub(int $skillClub): self
    {
        $this->skillClub = $skillClub;

        return $this;
    }

    public function getSkillClubTries(): ?int
    {
        return $this->skillClubTries;
    }

    public function setSkillClubTries(int $skillClubTries): self
    {
        $this->skillClubTries = $skillClubTries;

        return $this;
    }

    public function getSkillSword(): ?int
    {
        return $this->skillSword;
    }

    public function setSkillSword(int $skillSword): self
    {
        $this->skillSword = $skillSword;

        return $this;
    }

    public function getSkillSwordTries(): ?int
    {
        return $this->skillSwordTries;
    }

    public function setSkillSwordTries(int $skillSwordTries): self
    {
        $this->skillSwordTries = $skillSwordTries;

        return $this;
    }

    public function getSkillAxe(): ?int
    {
        return $this->skillAxe;
    }

    public function setSkillAxe(int $skillAxe): self
    {
        $this->skillAxe = $skillAxe;

        return $this;
    }

    public function getSkillAxeTries(): ?int
    {
        return $this->skillAxeTries;
    }

    public function setSkillAxeTries(int $skillAxeTries): self
    {
        $this->skillAxeTries = $skillAxeTries;

        return $this;
    }

    public function getSkillDist(): ?int
    {
        return $this->skillDist;
    }

    public function setSkillDist(int $skillDist): self
    {
        $this->skillDist = $skillDist;

        return $this;
    }

    public function getSkillDistTries(): ?int
    {
        return $this->skillDistTries;
    }

    public function setSkillDistTries(int $skillDistTries): self
    {
        $this->skillDistTries = $skillDistTries;

        return $this;
    }

    public function getSkillShielding(): ?int
    {
        return $this->skillShielding;
    }

    public function setSkillShielding(int $skillShielding): self
    {
        $this->skillShielding = $skillShielding;

        return $this;
    }

    public function getSkillShieldingTries(): ?int
    {
        return $this->skillShieldingTries;
    }

    public function setSkillShieldingTries(int $skillShieldingTries): self
    {
        $this->skillShieldingTries = $skillShieldingTries;

        return $this;
    }

    public function getSkillFishing(): ?int
    {
        return $this->skillFishing;
    }

    public function setSkillFishing(int $skillFishing): self
    {
        $this->skillFishing = $skillFishing;

        return $this;
    }

    public function getSkillFishingTries(): ?int
    {
        return $this->skillFishingTries;
    }

    public function setSkillFishingTries(int $skillFishingTries): self
    {
        $this->skillFishingTries = $skillFishingTries;

        return $this;
    }

    public function getAccount(): ?Accounts
    {
        return $this->account;
    }

    public function setAccount(?Accounts $account): self
    {
        $this->account = $account;

        return $this;
    }

    /**
     * @return Collection|Guilds[]
     */
    public function getGuild(): Collection
    {
        return $this->guild;
    }

    public function addGuild(Guilds $guild): self
    {
        if (!$this->guild->contains($guild)) {
            $this->guild[] = $guild;
        }

        return $this;
    }

    public function removeGuild(Guilds $guild): self
    {
        if ($this->guild->contains($guild)) {
            $this->guild->removeElement($guild);
        }

        return $this;
    }

}
