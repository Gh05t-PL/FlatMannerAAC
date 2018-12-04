<?php

namespace App\Utils\Strategy\Players;


use App\Utils\Configs;
use App\Utils\Strategy\UnifiedEntities\Player;
use Doctrine\ORM\Query\ResultSetMapping;
use Symfony\Bridge\Doctrine\RegistryInterface;

class PlayersStrategy12 implements IPlayersStrategy
{

    private $doctrine;

    public function __construct(RegistryInterface $doctrine)
    {
        $this->doctrine = $doctrine;
    }


    function getPlayerByName(string $name): Player
    {
        $player = $this->doctrine
            ->getRepository(\App\Entity\TFS12\Players::class)
            ->findOneBy([
                'name' => $name,
            ]);
        if ( $player == null )
            return null;
        // Player Kills
        $player->kills = $this->getPlayerFragsCount($player->getId());

        // Player Frags player::$pk [["name"]=> string( name of killed person ), ["level"]=> int( level of killed person), ["date"]=> int( when killed that person )], 
        // ["unjustified"]=> int( sqlbool 0:false, 1:true )]]
        $player->pk = $this->getPlayerFrags($player->getId());
        // ONLINE
        $player->online = $this->isPlayerOnline($player->getId());

        //Deaths by Players  player::$deathsByPlayers [["names"]=> string( exploded in view by "," ), ["level"]=> int(), ["date"]=> int()]]
        $player->deathsByPlayers = $this->getPlayerDeathsByPlayers($player->getId());

        //Deaths by Monsters  player::$deathsByMonsters [["killers"]=> string( exploded in view by "," ), ["level"]=> int(), ["date"]=> int()]]
        $player->deathsByMonsters = $this->getPlayerDeathsByMonsters($player->getId());

        //player::$guild [["guildName"]=> string(), ["rankName"]=> string(), ["guildId"]=> string()]]
        $player->guilds = $this->getPlayerGuildMembership($player);
        // EXP DIFF
        $player->expDiff = $this->getPlayerTodayExp($player->getId());


        $player->skills = [
            (object)['value' => $player->getSkillFist()],
            (object)['value' => $player->getSkillClub()],
            (object)['value' => $player->getSkillSword()],
            (object)['value' => $player->getSkillAxe()],
            (object)['value' => $player->getSkillDist()],
            (object)['value' => $player->getSkillShielding()],
            (object)['value' => $player->getSkillFishing()],
        ];


        /*echo $player->getStamina();
        $finalResult = (object)[
            'name' => $player->getName(),
            'isOnline' => $player->online,
            'vocation' => $player->getVocation(),
            'level' => $player->getLevel(),
            'experience' => $player-a>getExperience(),
            'maglevel' => $player->getMaglevel(),
            'health' => $player->getHealth(),
            'healthmax' => $player->getHealthmax(),
            'mana' => $player->getMana(),
            'manamax' => $player->getManamax(),
            'soul' => $player->getSoul(),
            'cap' => $player->getCap(),
            'stamina' => ($player->getStamina() * 60 * 1000),
            'skills' => $player->skills,
            'deathsByPlayers' => $player->deathsByPlayers,
            'deathsByMonsters' => $player->deathsByMonsters,
            'pk' => $player->pk,
            'kills' => $player->kills,
            'guild' => $player->guilds,
            'expDiff' => $player->expDiff,
            'townId' => $player->getTownId(),
            'lastlogin' => $player->getLastlogin(),
            'balance' => $player->getBalance(),
        ];
        return $finalResult;*/
        $pplayer = new Player($player->getId());
        $pplayer->setName($player->getName())
            ->setIsOnline($this->isPlayerOnline($player->getId()))
            ->setVocation($player->getVocation())
            ->setLevel($player->getLevel())
            ->setExperience($player->getExperience())
            ->setMaglevel($player->getMaglevel())
            ->setHealth($player->getHealth())
            ->setHealthmax($player->getHealthmax())
            ->setMana($player->getMana())
            ->setManamax($player->getManamax())
            ->setSoul($player->getSoul())
            ->setCap($player->getCap())
            ->setStamina($player->getStamina())
            ->setTownId($player->getTownId())
            ->setLastlogin($player->getLastlogin())
            ->setBalance($player->getBalance())
            ->setSkills($player->skills)
            ->setDeathsByPlayers($player->deathsByPlayers)
            ->setDeathsByMonsters($player->deathsByMonsters)
            ->setPk($player->pk)
            ->setKills($player->kills)
            ->setGuild($player->guilds)
            ->setExpDiff($player->expDiff);

        return $pplayer;

    }


    public function getPlayerBy($criteria)
    {
        return $this->doctrine
            ->getRepository(\App\Entity\TFS12\Players::class)
            ->findOneBy($criteria);
    }


    public function getOnlinePlayers()
    {
        $rsm = new ResultSetMapping;
        $rsm->addScalarResult('name', 'name');
        $rsm->addScalarResult('level', 'level');
        $rsm->addScalarResult('vocation', 'vocation');

        $onlines = $this->doctrine->getManager()
            ->createNativeQuery("SELECT name, level, vocation FROM players t1 INNER JOIN (SELECT * FROM `players_online` WHERE 1) t2 ON t1.id = t2.`player_id`", $rsm)
            ->getResult();
        return $onlines;
    }

    public function getPlayerFrags(int $id)
    {
        $rsm = new ResultSetMapping;
        $rsm->addScalarResult('id', 'id');
        $rsm->addScalarResult('fragName', 'name');
        $rsm->addScalarResult('date', 'time');
        $rsm->addScalarResult('fragLevel', 'level');
        $rsm->addScalarResult('unjustified', 'unjustified');

        $playerPK = $this->doctrine->getManager()
            ->createNativeQuery("SELECT id, t1.name as fragName, t2.time as date, t2.level as fragLevel, t2.unjustified FROM players t1 INNER JOIN (SELECT * FROM `player_deaths` WHERE `killed_by` in (select name from players where id = {$id}) AND is_player = 1) t2 ON t1.id = t2.player_id ORDER BY date DESC LIMIT " . Configs::$config['deathListLimit'], $rsm)
            ->getResult();
        $playerPkTemp = [];
        foreach ($playerPK as $key => $value)
        {
            $playerPkTemp[] = (object)[
                'name' => $value['name'],
                'level' => $value['level'],
                'date' => $value['time'],
                'unjustified' => $value['unjustified'],
            ];
        }

        return $playerPkTemp;
    }

    public function getPlayerFragsCount(int $id)
    {
        $rsm = new ResultSetMapping;
        $rsm->addScalarResult('count(*)', 'count');

        return (int)$this->doctrine->getManager()
            ->createNativeQuery("SELECT count(*) FROM `player_deaths` WHERE `killed_by` in (select name from players where id = {$id}) AND is_player = 1", $rsm)
            ->getSingleScalarResult();
    }

    public function isPlayerOnline(int $id)
    {
        $rsm = new ResultSetMapping;
        $rsm->addScalarResult('player_id', 'id');

        $playerOnline = $this->doctrine->getManager()
            ->createNativeQuery("SELECT * FROM players_online WHERE player_id = {$id}", $rsm)
            ->getResult();
        if ( empty($playerOnline) )
            return false;
        else
            return true;
    }

    public function getPlayerDeathsByPlayers(int $id)
    {
        $rsm = new ResultSetMapping;
        $rsm->addScalarResult('killed_by', 'names');
        $rsm->addScalarResult('level', 'level');
        $rsm->addScalarResult('time', 'date');
        $rsm->addScalarResult('unjustified', 'unjustified');

        return $this->doctrine->getManager()
            ->createNativeQuery("SELECT time,level,killed_by,unjustified FROM `player_deaths` WHERE `player_id` = {$id} AND is_player = 1 LIMIT " . Configs::$config['deathListLimit'], $rsm)
            ->getArrayResult();
    }

    public function getPlayerDeathsByMonsters(int $id)
    {
        $rsm = new ResultSetMapping;
        $rsm->addScalarResult('killed_by', 'killers');
        $rsm->addScalarResult('level', 'level');
        $rsm->addScalarResult('time', 'date');
        $rsm->addScalarResult('unjustified', 'unjustified');

        return $this->doctrine->getManager()
            ->createNativeQuery("SELECT time,level,killed_by,unjustified FROM `player_deaths` WHERE `player_id` = {$id} AND is_player = 0 LIMIT " . Configs::$config['deathListLimit'], $rsm)
            ->getResult();
    }

    public function getPlayerGuildMembership($player)
    {
        $member = $this->doctrine
            ->getRepository(\App\Entity\TFS12\GuildMembership::class)
            ->findOneBy([
                'player' => $player,
            ]);


        if ( $member !== null )
        {
            return [
                "guildName" => $member->getGuild()->getName(),
                "rankName" => $member->getRank()->getName(),
                "guildId" => $member->getGuild()->getId(),
            ];
        } else
        {
            return "No Membership";
        }
    }

    public function getPlayerTodayExp(int $id)
    {
        $rsm = new ResultSetMapping;
        $rsm->addScalarResult('expDiff', 'expDiff');
        try
        {
            return $this->doctrine->getManager()
                ->createNativeQuery("SELECT (t1.experience - expBefore) as expDiff FROM players t1 INNER JOIN (SELECT player_id, exp as expBefore FROM today_exp) t2 ON t1.id = t2.player_id where id = {$id}", $rsm)
                ->getSingleScalarResult();
        } catch (\Exception $e)
        {
            return 0;
        }
    }

}