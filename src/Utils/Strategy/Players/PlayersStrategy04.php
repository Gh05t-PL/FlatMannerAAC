<?php
namespace App\Utils\Strategy\Players;


use Doctrine\ORM\Query\ResultSetMapping;
use Symfony\Bridge\Doctrine\RegistryInterface;

class PlayersStrategy04 implements IPlayersStrategy
{

    private $doctrine;

    public function __construct(RegistryInterface $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    

    function getPlayerByName($name){
        //TFS0.4
        $config['ver'] = "0.4";
        
        $player = $this->doctrine
            ->getRepository(\App\Entity\TFS04\Players::class)
        ->findOneBy([
            'name' => $name,
        ]);
        if ( $player == NULL )
            return NULL;
        //Player Kills count in player::$kills
        $playerPK = $this->doctrine
            ->getRepository(\App\Entity\TFS04\PlayerKiller::class)
        ->findBy([
            'killer' => $player->getId(),
        ],[
            'id' => "DESC"
        ],10);
        $player->kills = count($playerPK);

        // Player Frags player::$pk [["name"]=> string( name of killed person ), ["level"]=> int( level of killed person), ["date"]=> int( when killed that person )], 
        // ["unjustified"]=> int( sqlbool 0:false, 1:true )]] 
        $playerPKTemp = [];
        foreach ($playerPK as $key => $value) {
            $playerPKTemp[] = [
                'name' => $value->getKill()->getDeath()->getPlayer()->getName(),
                'level' => $value->getKill()->getDeath()->getLevel(),
                'date' => $value->getKill()->getDeath()->getDate(),
                'unjustified' => $value->getKill()->isUnjustified(),
            ];
        }
        $ff = function ($a, $b) {
            if ((int)$a['date'] == (int)$b['date']) {
                return 0;
            }
            return ((int)$a['date'] < (int)$b['date']) ? 1 : -1;
        };
        usort($playerPKTemp, $ff);

        echo "<br>";echo "<br>";
        //var_dump($playerPKTemp);echo "<br>";echo "<br>";

        
        $player->pk = $playerPKTemp;
        $playerPK = null;

        
        //player::$guild [["guildName"]=> string(), ["rankName"]=> string(), ["guildId"]=> string()]]
        if ( $player->getRankId() > 0 ){
            $rsm = new ResultSetMapping;
            $rsm->addScalarResult('guild_name', 'guildName');
            $rsm->addScalarResult('guildId', 'guildId');
            $rsm->addScalarResult('rank_name', 'rankName');

            $player->guild = $this->doctrine->getManager()
                ->createNativeQuery("SELECT guild_name,rank_name,guildId FROM players t3 INNER JOIN ( SELECT t2.name as guild_name, t2.id as guildId, t1.name as rank_name, t1.id as rankID FROM guild_ranks t1 INNER JOIN (SELECT * FROM guilds) t2 ON t1.guild_id = t2.id) t4 ON t3.rank_id = t4.rankID WHERE id = {$player->getId()}", $rsm)
            ->getScalarResult()[0];
            
        }else{
            $player->guild = "No Membership";
        }
        
        //Deaths by Player  player::$deathsByPlayers [["names"]=> string( exploded in view by "," ), ["level"]=> int(), ["date"]=> int()]] 
        $rsm = new ResultSetMapping;
        $rsm->addScalarResult('names', 'names');
        $rsm->addScalarResult('levels', 'level');
        $rsm->addScalarResult('date', 'date');

        $deathsByPlayers = $this->doctrine->getManager()
            ->createNativeQuery("SELECT GROUP_CONCAT(name SEPARATOR ',') as names,date, `death_id`,levels FROM players t5 RIGHT JOIN (SELECT t3.player_id, level as levels, date, `death_id` FROM player_killers t3 INNER JOIN (SELECT * FROM player_deaths t1 INNER JOIN (SELECT `id` as `killer_id`, `death_id` FROM `killers`) t2 on t1.id = t2.death_id WHERE `player_id`={$player->getId()}) t4 on t3.kill_id = t4.killer_id ) t6 on t5.id = t6.player_id GROUP BY death_id", $rsm)
        ->getArrayResult();
        $player->deathsByPlayers = $deathsByPlayers;
        
        //Deaths by Monsters  player::$deathsByMonsters [["killers"]=> string( exploded in view by "," ), ["level"]=> int(), ["date"]=> int()]] 
        $rsm = new ResultSetMapping;
        $rsm->addScalarResult('killers_name', 'killers');
        $rsm->addScalarResult('level', 'level');
        $rsm->addScalarResult('date', 'date');

        $deathsByMonsters = $this->doctrine->getManager()
            ->createNativeQuery("SELECT GROUP_CONCAT(name SEPARATOR ', ') as killers_name, level, date FROM environment_killers t3 INNER JOIN (SELECT * FROM player_deaths t1 INNER JOIN (SELECT `id` as `killer_id`, `death_id` FROM `killers`) t2 on t1.id = t2.death_id WHERE `player_id`={$player->getId()}) t4 on t3.kill_id = t4.killer_id GROUP BY death_id", $rsm)
        ->getResult();
        $player->deathsByMonsters = $deathsByMonsters;
        //\var_dump($player->deathsByMonsters);

        // EXP DIFF  player::$expDiff int()
        $rsm = new ResultSetMapping;
        $rsm->addScalarResult('expDiff', 'expDiff');
        try {
            $expDiff = $this->doctrine->getManager()
                ->createNativeQuery("SELECT (t1.experience - expBefore) as expDiff FROM players t1 INNER JOIN (SELECT player_id, exp as expBefore FROM today_exp) t2 ON t1.id = t2.player_id where id = {$player->getId()}", $rsm)
            ->getSingleScalarResult();
        } catch (\Exception $e){$expDiff = 0;}
        
        
        $player->expDiff = $expDiff;
        //\var_dump($player);

        $playerSkills = $this->doctrine
            ->getRepository(\App\Entity\TFS04\PlayerSkill::class)
        ->findBy([
            'player' => $player->getId(),
        ]);
        $playerskillstemp = [];
        foreach ($playerSkills as $key => $value) {
            $playerskillstemp[] = (object)[
                'value' => $value->getValue(),
            ];
            
        }
        $playerSkills = null;
        
        $player->skills = $playerskillstemp;
        
        $finalResult = (object)[
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
            'maglevel' => $player->getMaglevel(),
            'skills' => $player->skills,
            'deathsByPlayers' => $player->deathsByPlayers,
            'deathsByMonsters' => $player->deathsByMonsters,
            'deathsByMonsters' => $player->deathsByMonsters,
            'pk' => $player->pk,
            'kills' => $player->kills,
            'guild' => $player->guild,
            'expDiff' => $player->expDiff,
        ];
        //\var_dump($finalResult);echo '<br>';echo '<br>';echo '<br>';
        //echo json_encode($finalResult);
        return $finalResult;

        
    }


    public function getPlayerBy($criteria)
    {
        return $this->doctrine
            ->getRepository(\App\Entity\TFS04\Players::class)
        ->findOneBy($criteria);
    }


    public function getOnlinePlayers()
    {
        $onlines = $this->doctrine
            ->getRepository(\App\Entity\TFS04\Players::class)
        ->findBy([
            'online' => 1,
        ]);

        return $onlines;
    }


}





?>