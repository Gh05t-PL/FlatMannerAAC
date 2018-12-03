<?php

namespace App\Utils\Strategy\Players;


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
        //TFS0.4
        $config['ver'] = "0.4";


        $player = $this->doctrine
            ->getRepository(\App\Entity\TFS12\Players::class)
            ->findOneBy([
                'name' => $name,
            ]);
        if ( $player == null )
            return null;
        // Player Kills
        $rsm = new ResultSetMapping;
        $rsm->addScalarResult('count(*)', 'count');

        $player->kills = $this->doctrine->getManager()
            ->createNativeQuery("SELECT count(*) FROM `player_deaths` WHERE `killed_by` in (select name from players where id = {$player->getId()}) AND is_player = 1", $rsm)
            ->getSingleScalarResult();

        // Player Frags player::$pk [["name"]=> string( name of killed person ), ["level"]=> int( level of killed person), ["date"]=> int( when killed that person )], 
        // ["unjustified"]=> int( sqlbool 0:false, 1:true )]] 
        $rsm = new ResultSetMapping;
        $rsm->addScalarResult('id', 'id');
        $rsm->addScalarResult('fragName', 'name');
        $rsm->addScalarResult('date', 'time');
        $rsm->addScalarResult('fragLevel', 'level');
        $rsm->addScalarResult('unjustified', 'unjustified');

        $playerPK = $this->doctrine->getManager()
            ->createNativeQuery("SELECT id, t1.name as fragName, t2.time as date, t2.level as fragLevel, t2.unjustified FROM players t1 INNER JOIN (SELECT * FROM `player_deaths` WHERE `killed_by` in (select name from players where id = {$player->getId()}) AND is_player = 1) t2 ON t1.id = t2.player_id ORDER BY date DESC LIMIT 10", $rsm)
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
        $playerPK = null;

        //\var_dump($playerPkTemp);
        $player->pk = $playerPkTemp;


        // ONLINE
        $rsm = new ResultSetMapping;
        $rsm->addScalarResult('player_id', 'id');

        $playerOnline = $this->doctrine->getManager()
            ->createNativeQuery("SELECT * FROM players_online WHERE player_id = {$player->getId()}", $rsm)
            ->getResult();
        if ( empty($playerOnline) )
            $player->online = false;
        else
            $player->online = true;

        //Deaths by Players  player::$deathsByPlayers [["names"]=> string( exploded in view by "," ), ["level"]=> int(), ["date"]=> int()]] 
        $rsm = new ResultSetMapping;
        $rsm->addScalarResult('killed_by', 'names');
        $rsm->addScalarResult('level', 'level');
        $rsm->addScalarResult('time', 'date');
        $rsm->addScalarResult('unjustified', 'unjustified');

        $deathsByPlayers = $this->doctrine->getManager()
            ->createNativeQuery("SELECT time,level,killed_by,unjustified FROM `player_deaths` WHERE `player_id` = {$player->getId()} AND is_player = 1", $rsm)
            ->getArrayResult();

        $player->deathsByPlayers = $deathsByPlayers;

        //Deaths by Monsters  player::$deathsByMonsters [["killers"]=> string( exploded in view by "," ), ["level"]=> int(), ["date"]=> int()]] 
        $rsm = new ResultSetMapping;
        $rsm->addScalarResult('killed_by', 'killers');
        $rsm->addScalarResult('level', 'level');
        $rsm->addScalarResult('time', 'date');
        $rsm->addScalarResult('unjustified', 'unjustified');

        $deathsByMonsters = $this->doctrine->getManager()
            ->createNativeQuery("SELECT time,level,killed_by,unjustified FROM `player_deaths` WHERE `player_id` = {$player->getId()} AND is_player = 0", $rsm)
            ->getResult();

        $player->deathsByMonsters = $deathsByMonsters;

        //player::$guild [["guildName"]=> string(), ["rankName"]=> string(), ["guildId"]=> string()]]
        $member = $this->doctrine
            ->getRepository(\App\Entity\TFS12\GuildMembership::class)
            ->findOneBy([
                'player' => $player,
            ]);


        if ( $member !== null )
        {
            $player->guilds = [
                "guildName" => $member->getGuild()->getName(),
                "rankName" => $member->getRank()->getName(),
                "guildId" => $member->getGuild()->getId(),
            ];
        } else
        {
            $player->guilds = "No Membership";
        }
        // EXP DIFF
        $rsm = new ResultSetMapping;
        $rsm->addScalarResult('expDiff', 'expDiff');
        try
        {
            $expDiff = $this->doctrine->getManager()
                ->createNativeQuery("SELECT (t1.experience - expBefore) as expDiff FROM players t1 INNER JOIN (SELECT player_id, exp as expBefore FROM today_exp) t2 ON t1.id = t2.player_id where id = {$player->getId()}", $rsm)
                ->getSingleScalarResult();
        } catch (\Exception $e)
        {
            $expDiff = 0;
        }
        $player->expDiff = $expDiff;


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
            'experience' => $player->getExperience(),
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
            ->setIsOnline($player->isOnline())
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


}