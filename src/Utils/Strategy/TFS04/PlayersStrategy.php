<?php

namespace App\Utils\Strategy\TFS04;


use App\Utils\Configs;
use App\Utils\Strategy\UnifiedEntities\Account;
use App\Utils\Strategy\UnifiedEntities\Player;
use Doctrine\ORM\Query\ResultSetMapping;
use Symfony\Bridge\Doctrine\RegistryInterface;

class PlayersStrategy implements \App\Utils\Strategy\IPlayersStrategy
{

    private $doctrine;

    public function __construct(RegistryInterface $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    function getPlayerByName(string $name): ?Player
    {
        //TFS0.4
        $config['ver'] = "0.4";

        $player = $this->doctrine
            ->getRepository(\App\Entity\TFS04\Players::class)
            ->findOneBy([
                'name' => $name,
            ]);
        if ( $player == null )
            return null;


        // Player Frags player::$pk [["name"]=> string( name of killed person ), ["level"]=> int( level of killed person), ["date"]=> int( when killed that person )],
        // ["unjustified"]=> int( sqlbool 0:false, 1:true )]]
        $playerPK = $this->getPlayerFrags($player->getId());
        $player->kills = $this->getPlayerFragsCount($player->getId());
        $player->pk = $playerPK;
        //player::$guild [["guildName"]=> string(), ["rankName"]=> string(), ["guildId"]=> string()]]
        $player->guild = $this->getPlayerGuildMembership($player);
        //Deaths by Player  player::$deathsByPlayers [["names"]=> string( exploded in view by "," ), ["level"]=> int(), ["date"]=> int()]]
        $player->deathsByPlayers = $this->getPlayerDeathsByPlayers($player->getId());
        //Deaths by Monsters  player::$deathsByMonsters [["killers"]=> string( exploded in view by "," ), ["level"]=> int(), ["date"]=> int()]]
        $player->deathsByMonsters = $this->getPlayerDeathsByMonsters($player->getId());
        // EXP DIFF  player::$expDiff int()
        $player->expDiff = $this->getPlayerTodayExp($player->getId());
        //Indexed array(0-6) of skill->value
        $player->skills = $this->getPlayerSkills($player->getId());

        /*$finalResult = (object)[
            'name' => $player->getName(),
            'isOnline' => $player->isOnline(),
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
            'stamina' => $player->getStamina(),
            'skills' => $player->skills,
            'deathsByPlayers' => $player->deathsByPlayers,
            'deathsByMonsters' => $player->deathsByMonsters,
            'pk' => $player->pk,
            'kills' => $player->kills,
            'guild' => $player->guild,
            'expDiff' => $player->expDiff,
            'townId' => $player->getTownId(),
            'lastlogin' => $player->getLastlogin(),
            'balance' => $player->getBalance(),
        ];*/
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
            ->setGuild($player->guild)
            ->setExpDiff($player->expDiff);


        //\var_dump($finalResult);echo '<br>';echo '<br>';echo '<br>';
        //echo json_encode($finalResult);
        return $pplayer;
    }

    public function getPlayerFrags(int $id)
    {
        $playerPK = $this->doctrine
            ->getRepository(\App\Entity\TFS04\PlayerKiller::class)
            ->findBy([
                'killer' => $id,
            ], [
                'id' => "DESC",
            ], Configs::$config['deathListLimit']);
        $playerPKTemp = [];
        foreach ($playerPK as $key => $value)
        {
            $playerPKTemp[] = [
                'name' => $value->getKill()->getDeath()->getPlayer()->getName(),
                'level' => $value->getKill()->getDeath()->getLevel(),
                'date' => $value->getKill()->getDeath()->getDate(),
                'unjustified' => $value->getKill()->isUnjustified(),
            ];
        }
//        $ff = function ($a, $b) {
//            if ( (int)$a['date'] == (int)$b['date'] )
//            {
//                return 0;
//            }
//            return ((int)$a['date'] < (int)$b['date']) ? 1 : -1;
//        };
//        usort($playerPKTemp, $ff);
        return $playerPKTemp;
    }

    /*
     *
     *     public function getPlayerBy($criteria)
        {
            $player = $this->doctrine
                ->getRepository(\App\Entity\TFS04\Players::class)
                ->findOneBy($criteria);
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
                ->setBalance($player->getBalance());
            return $pplayer;
        }

     *
     */

    public function getPlayerFragsCount(int $id)
    {
        $playerPK = $this->doctrine
            ->getRepository(\App\Entity\TFS04\PlayerKiller::class)
            ->findBy([
                'killer' => $id,
            ]);

        return count($playerPK);
    }

    public function getPlayerGuildMembership($player)
    {
        if ( $player->getRankId() > 0 )
        {
            $rsm = new ResultSetMapping;
            $rsm->addScalarResult('guild_name', 'guildName');
            $rsm->addScalarResult('guildId', 'guildId');
            $rsm->addScalarResult('rank_name', 'rankName');
            /*var_dump($player->guild = $this->doctrine->getManager()
                ->createNativeQuery("SELECT guild_name,rank_name,guildId FROM players t3 INNER JOIN ( SELECT t2.name as guild_name, t2.id as guildId, t1.name as rank_name, t1.id as rankID FROM guild_ranks t1 INNER JOIN (SELECT * FROM guilds) t2 ON t1.guild_id = t2.id) t4 ON t3.rank_id = t4.rankID WHERE id = {$player->getId()}", $rsm)
                ->getScalarResult());*/
            return $this->doctrine->getManager()
                ->createNativeQuery("SELECT guild_name,rank_name,guildId FROM players t3 INNER JOIN ( SELECT t2.name as guild_name, t2.id as guildId, t1.name as rank_name, t1.id as rankID FROM guild_ranks t1 INNER JOIN (SELECT * FROM guilds) t2 ON t1.guild_id = t2.id) t4 ON t3.rank_id = t4.rankID WHERE id = {$player->getId()}", $rsm)
                ->getScalarResult()[0];

        } else
        {
            return "No Membership";
        }
    }

    public function getPlayerDeathsByPlayers(int $id)
    {
        $rsm = new ResultSetMapping;
        $rsm->addScalarResult('names', 'names');
        $rsm->addScalarResult('levels', 'level');
        $rsm->addScalarResult('date', 'date');

        return $this->doctrine->getManager()
            ->createNativeQuery("SELECT GROUP_CONCAT(name SEPARATOR ',') as names,date, `death_id`,levels FROM players t5 RIGHT JOIN (SELECT t3.player_id, level as levels, date, `death_id` FROM player_killers t3 INNER JOIN (SELECT * FROM player_deaths t1 INNER JOIN (SELECT `id` as `killer_id`, `death_id` FROM `killers`) t2 on t1.id = t2.death_id WHERE `player_id`={$id}) t4 on t3.kill_id = t4.killer_id ) t6 on t5.id = t6.player_id GROUP BY death_id ORDER BY date DESC LIMIT " . Configs::$config['deathListLimit'], $rsm)
            ->getArrayResult();
    }

    public function getPlayerDeathsByMonsters(int $id)
    {
        $rsm = new ResultSetMapping;
        $rsm->addScalarResult('killers_name', 'killers');
        $rsm->addScalarResult('level', 'level');
        $rsm->addScalarResult('date', 'date');

        return $this->doctrine->getManager()
            ->createNativeQuery("SELECT GROUP_CONCAT(name SEPARATOR ', ') as killers_name, level, date FROM environment_killers t3 INNER JOIN (SELECT * FROM player_deaths t1 INNER JOIN (SELECT `id` as `killer_id`, `death_id` FROM `killers`) t2 on t1.id = t2.death_id WHERE `player_id`={$id}) t4 on t3.kill_id = t4.killer_id GROUP BY death_id ORDER BY date DESC LIMIT " . Configs::$config['deathListLimit'], $rsm)
            ->getResult();
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

    public function getPlayerSkills(int $id)
    {
        $playerSkills = $this->doctrine
            ->getRepository(\App\Entity\TFS04\PlayerSkill::class)
            ->findBy([
                'player' => $id,
            ]);
        $playerskillstemp = [];
        foreach ($playerSkills as $key => $value)
        {
            $playerskillstemp[] = (object)[
                'value' => $value->getValue(),
            ];

        }
        return $playerskillstemp;
    }

    public function getPlayerBy($criteria): ?Player
    {
        $player = $this->doctrine
            ->getRepository(\App\Entity\TFS04\Players::class)
            ->findOneBy($criteria);
        if ( $player === null )
            return null;
        $pplayer = new Player($player->getId(), $this->doctrine);
        $account = new Account($player->getAccount()->getId());
        $account->setName($player->getAccount()->getName())
            ->setPassword($player->getAccount()->getPassword())
            ->setGroupId($player->getAccount()->getGroupId())
            ->setPoints($player->getAccount()->getPoints());

        return $pplayer->setName($player->getName())
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
            ->setExpDiff($this->getPlayerTodayExp($player->getId()))
            ->setAccount($account);
    }

    /**
     * @return \App\Utils\Strategy\UnifiedEntities\Player[]
     */
    public function getOnlinePlayers()
    {
        $onlines = $this->doctrine
            ->getRepository(\App\Entity\TFS04\Players::class)
            ->findBy([
                'online' => 1,
            ]);
        foreach ($onlines as $key => $value)
        {
            $onlines[$key] = (new Player())->setName($value->getName())
                ->setLevel($value->getLevel())
                ->setVocation($value->getVocation());
        }
        return $onlines;
    }


}