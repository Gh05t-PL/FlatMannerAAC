<?php
/**
 * Created by PhpStorm.
 * User: wiktor
 * Date: 18.11.2018
 * Time: 13:56
 */

namespace App\Utils\Strategy\UnifiedEntities;

use App\Utils\Configs;
use Symfony\Bridge\Doctrine\RegistryInterface;

class Player
{// TODO active record?
    private $id = null;
    private $account = null;
    private $name = null;
    private $isOnline = null;
    private $vocation = null;
    private $level = null;
    private $experience = null;
    private $maglevel = null;
    private $health = null;
    private $healthmax = null;
    private $mana = null;
    private $manamax = null;
    private $soul = null;
    private $cap = null;
    private $stamina = null;
    private $skills = null;
    private $deathsByPlayers = null;
    private $deathsByMonsters = null;
    private $pk = null;
    private $kills = null;
    private $guild = null;
    private $expDiff = null;
    private $townId = null;
    private $lastlogin = null;
    private $balance = null;

    // for active record
    private $doctrine = null;

    public function __construct(int $id = null, RegistryInterface $doctrine = null)
    {
        $this->id = $id;
        $this->doctrine = $doctrine;
    }

    /**
     * @return int Player id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return bool
     */
    public function isOnline()
    {
        return $this->isOnline;
    }

    /**
     * @return int
     */
    public function getVocation()
    {
        return $this->vocation;
    }

    /**
     * @return int
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * @return int
     */
    public function getExperience()
    {
        return $this->experience;
    }

    /**
     * @return int
     */
    public function getMaglevel()
    {
        return $this->maglevel;
    }

    /**
     * @return int
     */
    public function getHealth()
    {
        return $this->health;
    }

    /**
     * @return int
     */
    public function getHealthmax()
    {
        return $this->healthmax;
    }

    /**
     * @return int
     */
    public function getMana()
    {
        return $this->mana;
    }

    /**
     * @return int
     */
    public function getManamax()
    {
        return $this->manamax;
    }

    /**
     * @return int
     */
    public function getSoul()
    {
        return $this->soul;
    }

    /**
     * @return int
     */
    public function getCap()
    {
        return $this->cap;
    }

    /**
     * @return int
     */
    public function getStamina()
    {
        return $this->stamina;
    }

    /**
     * @return array(0-6) $skill->value
     */
    public function getSkills()
    {
        return $this->skills;
    }

    /**
     * @return array(indexed) [["names"]=> string( exploded in view by "," ), ["level"]=> int(), ["date"]=> int()]]
     */
    public function getDeathsByPlayers()
    {
        return $this->deathsByPlayers;
    }

    /**
     * @return array(indexed) [["killers"]=> string( exploded in view by "," ), ["level"]=> int(), ["date"]=> int()]]
     */
    public function getDeathsByMonsters()
    {
        return $this->deathsByMonsters;
    }

    /**
     * @return array(indexed) [["name"]=> string( name of killed person ), ["level"]=> int( level of killed person), ["date"]=> int( when killed that person )],["unjustified"]=> int( sqlbool 0:false, 1:true )]]
     */
    public function getPk()
    {
        return $this->pk;
    }

    /**
     * @return int
     */
    public function getKills()
    {
        return $this->kills;
    }

    /**
     * @return [["guildName"]=> string(), ["rankName"]=> string(), ["guildId"]=> string()]]
     */
    public function getGuild()
    {
        return $this->guild;
    }

    /**
     * @return int
     */
    public function getExpDiff()
    {
        return $this->expDiff;
    }

    /**
     * @return int
     */
    public function getTownId()
    {
        return $this->townId;
    }

    /**
     * @return int
     */
    public function getLastlogin()
    {
        return $this->lastlogin;
    }

    /**
     * @return int
     */
    public function getBalance()
    {
        return $this->balance;
    }


    /* SETTERS */

    /**
     * @param string $name
     * @return Player
     */
    public function setName(string $name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @param bool $isOnline
     * @return Player
     */
    public function setIsOnline(bool $isOnline)
    {
        $this->isOnline = $isOnline;
        return $this;
    }

    /**
     * @param int $vocation
     * @return Player
     */
    public function setVocation(int $vocation)
    {
        $this->vocation = $vocation;
        return $this;
    }

    /**
     * @param int $level
     * @return Player
     */
    public function setLevel(int $level)
    {
        $this->level = $level;
        return $this;
    }

    /**
     * @param int $experience
     * @return Player
     */
    public function setExperience(int $experience)
    {
        $this->experience = $experience;
        return $this;
    }

    /**
     * @param int $maglevel
     * @return Player
     */
    public function setMaglevel(int $maglevel)
    {
        $this->maglevel = $maglevel;
        return $this;
    }

    /**
     * @param int $health
     * @return Player
     */
    public function setHealth(int $health)
    {
        $this->health = $health;
        return $this;
    }

    /**
     * @param int $healthmax
     * @return Player
     */
    public function setHealthmax(int $healthmax)
    {
        $this->healthmax = $healthmax;
        return $this;
    }

    /**
     * @param int $mana
     * @return Player
     */
    public function setMana(int $mana)
    {
        $this->mana = $mana;
        return $this;
    }

    /**
     * @param int $manamax
     * @return Player
     */
    public function setManamax(int $manamax)
    {
        $this->manamax = $manamax;
        return $this;
    }

    /**
     * @param int $soul
     * @return Player
     */
    public function setSoul(int $soul)
    {
        $this->soul = $soul;
        return $this;
    }

    /**
     * @param int $cap
     * @return Player
     */
    public function setCap(int $cap)
    {
        $this->cap = $cap;
        return $this;
    }

    /**
     * @param int $stamina
     * @return Player
     */
    public function setStamina(int $stamina)
    {
        $this->stamina = $stamina;
        return $this;
    }

    /**
     * <p>Accept Indexed array(0-6) of skill->value</p>
     * <p></p>
     * @param array $skills of skill->value $skills
     * @return Player
     */
    public function setSkills($skills)
    {
        $this->skills = $skills;
        return $this;
    }

    /**
     * <p>Accept Indexed array of [["names"]=> string( exploded in view by "," ), ["level"]=> int(), ["date"]=> int()]]</p>
     * <p></p>
     * @param array $deathsByPlayers of [["names"]=> string( exploded in view by "," ), ["level"]=> int(), ["date"]=> int()]]
     * @return Player
     */
    public function setDeathsByPlayers($deathsByPlayers)
    {
        $this->deathsByPlayers = $deathsByPlayers;
        return $this;
    }

    /**
     * @param array $deathsByMonsters of [["killers"]=> string( exploded in view by "," ), ["level"]=> int(), ["date"]=> int()]]
     * @return Player
     */
    public function setDeathsByMonsters($deathsByMonsters)
    {
        $this->deathsByMonsters = $deathsByMonsters;
        return $this;
    }

    /**
     * <p>Accept Indexed array of [["name"]=> string( name of killed person ), ["level"]=> int( level of killed person), ["date"]=> int( when killed that person )],["unjustified"]=> int( sqlbool 0:false, 1:true )]]</p>
     * <p></p>
     * @param array $pk
     * @return Player
     */
    public function setPk($pk)
    {
        $this->pk = $pk;
        return $this;
    }

    /**
     * @param int $kills
     * @return Player
     */
    public function setKills(int $kills)
    {
        $this->kills = $kills;
        return $this;
    }

    /**
     * @param array $guild [["guildName"]=> string(), ["rankName"]=> string(), ["guildId"]=> string()]]
     * @return Player
     */
    public function setGuild($guild)
    {
        $this->guild = $guild;
        return $this;
    }

    /**
     * @param int $expDiff
     * @return Player
     */
    public function setExpDiff(int $expDiff)
    {
        $this->expDiff = $expDiff;
        return $this;
    }

    /**
     * @param int $townId
     * @return Player
     */
    public function setTownId(int $townId)
    {
        $this->townId = $townId;
        return $this;
    }

    /**
     * @param int $lastlogin
     * @return Player
     */
    public function setLastlogin(int $lastlogin)
    {
        $this->lastlogin = $lastlogin;
        return $this;
    }

    /**
     * @param null $balance
     * @return Player
     */
    public function setBalance(int $balance)
    {
        $this->balance = $balance;
        return $this;
    }

    /**
     * @return Account
     */
    public function getAccount()
    {
        return $this->account;
    }

    /**
     * @param Account $account
     * @return Player
     */
    public function setAccount($account)
    {
        $this->account = $account;
        return $this;
    }

    public function delete()
    {
        $player = null;
        $class = "\\App\\Entity\\" . Configs::$config['version'] . "\\Players";

        $player = $this->doctrine->getRepository($class)->find($this->getId());

        $em = $this->doctrine->getManager();
        $em->remove($player);
        $em->flush();

    }

}