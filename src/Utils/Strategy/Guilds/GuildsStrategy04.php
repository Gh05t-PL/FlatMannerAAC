<?php
namespace App\Utils\Strategy\Guilds;


use Doctrine\ORM\Query\ResultSetMapping;
class GuildsStrategy04 implements IGuildsStrategy
{

    private $doctrine;

    public function __construct($doctrine)
    {
        $this->doctrine = $doctrine;
    }


    public function getGuildsList()
    {
        $rsm = new ResultSetMapping;
        $rsm->addScalarResult('id', 'id');
        $rsm->addScalarResult('name', 'name');
        $rsm->addScalarResult('motd', 'motd');
        $rsm->addScalarResult('members', 'members');

        $guilds = $this->doctrine->getManager()
            ->createNativeQuery("SELECT id,name,motd,IFNULL(membersCount,0) as members FROM guilds t3 LEFT JOIN (SELECT count(*) as membersCount,guild_id FROM players t1 INNER JOIN (SELECT * FROM guild_ranks) t2 ON t1.rank_id = t2.id group by guild_id) t4 ON t3.id = t4.guild_id", $rsm)
        ->getArrayResult();

        return $guilds;
    }


    public function getGuildById($id)
    {
        $guild = $this->doctrine
            ->getRepository(\App\Entity\TFS04\Guilds::class)
        ->find($id);

        return $guild;
    }


    public function getGuildBy($criteria)
    {
        $guild = $this->doctrine
            ->getRepository(\App\Entity\TFS04\Guilds::class)
        ->findOneBy($criteria);

        return $guild;
    }


    public function getGuildMembers($id)
    {
        $rsm = new ResultSetMapping;
        $rsm->addScalarResult('id', 'id');
        $rsm->addScalarResult('nick', 'nick');
        $rsm->addScalarResult('level', 'level');
        $rsm->addScalarResult('vocation', 'vocation');
        $rsm->addScalarResult('rank_id', 'rankId');
        $rsm->addScalarResult('guildnick', 'guildNick');
        $rsm->addScalarResult('rankName', 'rankName');
        $rsm->addScalarResult('rankLevel', 'rankLevel');
        $rsm->addScalarResult('account_id', 'accountId');

        $members = $this->doctrine->getManager()
            ->createNativeQuery("SELECT t1.id as id, t1.name as nick, t1.level as level, vocation, rank_id, guildnick, account_id, t2.name as rankName, t2.level as rankLevel FROM players t1 INNER JOIN (SELECT * FROM guild_ranks WHERE guild_id = {$id}) t2 ON t1.rank_id = t2.id ORDER BY rankLevel DESC, level DESC", $rsm)
        ->getArrayResult();

        return $members;
    }


    public function getGuildInvites($id)
    {
        // sql get invitations
        $rsm = new ResultSetMapping;
        $rsm->addScalarResult('id', 'id');
        $rsm->addScalarResult('nick', 'nick');
        $rsm->addScalarResult('level', 'level');
        $rsm->addScalarResult('vocation', 'vocation');
        $rsm->addScalarResult('account_id', 'account_id');

        $invitations = $this->doctrine->getManager()
            ->createNativeQuery("SELECT id, name as nick, level, vocation, account_id FROM players t1 INNER JOIN (SELECT * FROM guild_invites WHERE guild_id = {$id} ) t2 ON t1.id = t2.player_id ORDER BY level DESC", $rsm)
        ->getArrayResult();

        return $invitations;
    }


    public function getGuildRanks($gId)
    {
        $ranks = $this->doctrine
            ->getRepository(\App\Entity\TFS04\GuildRanks::class)
        ->findBy(['guild' => $gId], ['level' => "DESC"]);

        return $ranks;
    }


    public function createGuildRank($data)
    {
        $rank =  new \App\Entity\TFS04\GuildRanks;

        $rank->setGuild($data['guild']);
        $rank->setLevel($data['level']);
        $rank->setName($data['name']);
        
        $em = $this->doctrine->getManager();
        $em->persist($rank);
        $em->flush();
    }
    

    public function getAccountGuildRank($aId, $members)
    {
        // check max rank of members tide to logged in account
        $loggedRankLevel = 0;
        foreach ($members as $value) {
            if ( $value['accountId'] == $aId && $value['rankLevel'] > $loggedRankLevel )
                $loggedRankLevel = $value['rankLevel'];
        }

        return $loggedRankLevel;
    }


    public function setRank($pId,$rId)
    {
        $member = $this->doctrine
            ->getRepository(\App\Entity\TFS04\Players::class)
        ->find($pId);

        $member->setRankId($rId);

        $em = $this->doctrine->getManager();
        $em->persist($member);
        $em->flush();
    }





    public function createGuild($formData)
    {
        $guild = new \App\Entity\TFS04\Guilds();

        $guild->setName($formData['name']);
        $guild->setOwnerid($formData['leader']);
        $guild->setCreationdata(time());
        $guild->setMotd("Please edit motd in leader action panel");
        $guild->setCheckdata(time());

        $em = $this->doctrine->getManager();
        $em->persist($guild);
        $em->flush();


        // SET LEADER
        $rsm = new ResultSetMapping;
        $rsm->addScalarResult('id', 'id');

        $leaderRank = $this->doctrine->getManager()
            ->createNativeQuery("SELECT id FROM `guild_ranks` WHERE guild_id = {$guild->getId()} and level = 3", $rsm)
        ->getSingleScalarResult();

        $player = $this->doctrine->getRepository(\App\Entity\TFS04\Players::class)->find($formData['leader']);
        $player->setRankId($leaderRank);

        $em->persist($player);
        $em->flush();

        return $guild->getId();
    }


    public function deleteGuild($id)
    {
        $guild = $this->doctrine
            ->getRepository(\App\Entity\TFS04\Guilds::class)
        ->find($id);

        $em = $this->doctrine->getManager();
        $em->remove($guild);
        $em->flush();
    }


    public function acceptInvite($data)
    {
        $player = $this->doctrine
            ->getRepository(\App\Entity\TFS04\Players::class)
        ->find($data['playerId']);

        $player->setRankId($data['rankId']);

        $em = $this->doctrine->getManager();
        $em->persist($player);
        $em->flush();
    }


    public function leaveGuild($pId)
    {
        $player = $this->doctrine
            ->getRepository(\App\Entity\TFS04\Players::class)
        ->find($pId);

        $player->setRankId(0);

        $em = $this->doctrine->getManager();
        $em->persist($player);
        $em->flush();
    }


    public function isMember($pId)
    {
        $player = $this->doctrine
            ->getRepository(\App\Entity\TFS04\Players::class)
        ->find($pId);

        if ( $player->getRankId() != 0 )
            return true;

        return false;
    }


}