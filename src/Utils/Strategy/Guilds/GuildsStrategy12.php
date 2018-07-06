<?php
namespace App\Utils\Strategy\Guilds;


use Doctrine\ORM\Query\ResultSetMapping;
class GuildsStrategy12 implements IGuildsStrategy
{

    private $doctrine;

    public function __construct($doctrine)
    {
        $this->doctrine = $doctrine;
    }


    public function getGuildsList()
    {
        $guilds = $this->doctrine
            ->getRepository(\App\Entity\TFS12\Guilds::class)
        ->findBy(
            [],
            ['name' => 'ASC']
        );

        foreach ($guilds as $key => $value) {
            $value->members = count($this->doctrine
                ->getRepository(\App\Entity\TFS12\GuildMembership::class)
            ->findBy(['guild' => $value->getId()]));
        }

        return $guilds;
    }


    public function getGuildById($id)
    {
        $guild = $this->doctrine
            ->getRepository(\App\Entity\TFS12\Guilds::class)
        ->find($id);

        return $guild;
    }


    public function getGuildBy($criteria)
    {
        $guild = $this->doctrine
            ->getRepository(\App\Entity\TFS12\Guilds::class)
        ->findOneBy($criteria);

        return $guild;
    }


    public function getGuildMembers($id)
    {
        // $membersTemp = $this->doctrine
        //     ->getRepository(\App\Entity\TFS12\GuildMembership::class)
        // ->findBy([
        //     'guild' => $id
        // ]);

        $query = $this->doctrine
            ->getManager()
        ->createQuery("SELECT m, p, r FROM App\Entity\TFS12\GuildMembership m JOIN m.player p JOIN m.rank r WHERE m.guild = {$id} ORDER BY r.level DESC, p.level DESC");


        $membersTemp = $query->getResult();

        $members = [];

        // fetch data to 0.4 format
        foreach ($membersTemp as $key => $value) {
            $members[] = [
                'rankName' => $value->getRank()->getName(),
                'rankLevel' => $value->getRank()->getLevel(),
                'rankId' => $value->getRank()->getId(),
                'guildNick' => $value->getNick(),
                'accountId' => $value->getPlayer()->getAccount()->getId(),
                'nick' => $value->getPlayer()->getName(),
                'id' => $value->getPlayer()->getId(),
                'level' => $value->getPlayer()->getLevel(),
                'vocation' => $value->getPlayer()->getVocation(),
            ];
        }

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
        
    }


    public function getAccountGuildRank($aId, $members)
    {
        // check max rank of members tide to logged in account
        /*$loggedRankLevel = 0;
        foreach ($members as $value) {
            if ( $value->getPlayer()->getAccount()->getId() == $id && $value->getRank()->getLevel() > $loggedRankLevel )
                $loggedRankLevel = $value->getRank()->getLevel();
        }

        return $loggedRankLevel;*/

        $loggedRankLevel = 0;
        foreach ($members as $value) {
            if ( $value['accountId'] == $aId && $value['rankLevel'] > $loggedRankLevel )
                $loggedRankLevel = $value['rankLevel'];
        }

        return $loggedRankLevel;
    }





    public function createGuild($formData)
    {
        $guild = new \App\Entity\TFS12\Guilds();

        $guild->setName($formData['name']);
        
        $guild->setOwnerid($this->doctrine->getRepository(\App\Entity\TFS12\Players::class)->findOneBy( ['id' => $formData['leader']] ));
        $guild->setCreationdata(time());
        $guild->setMotd("Please edit motd in leader action panel");
        //SELECT id FROM `guild_ranks` WHERE guild_id = 4 and level = 3

        $em = $this->doctrine->getManager();
        $em->persist($guild);
        $em->flush();


        // SET LEADER
        $rsm = new ResultSetMapping;
        $rsm->addScalarResult('id', 'id');

        $leaderRank = $this->doctrine->getManager()
            ->createNativeQuery("SELECT id FROM `guild_ranks` WHERE guild_id = {$guild->getId()} and level = 3", $rsm)
        ->getSingleScalarResult();

        $player = $this->doctrine->getRepository(\App\Entity\TFS12\Players::class)->find($formData['leader']);
        

        $guildMember = new \App\Entity\TFS12\GuildMembership();
        $guildRank = $this->doctrine->getRepository(\App\Entity\TFS12\GuildRanks::class)->findOneBy(['guild' => $guild, 'level' => 3]);
        $guildMember->setGuild($guild)
            ->setPlayer($player)
        ->setRank($guildRank);

        $em->persist($guildMember);
        $em->flush();

        return $guild->getId();
    }


    public function deleteGuild($id)
    {
        $guild = $this->doctrine
            ->getRepository(\App\Entity\TFS12\Guilds::class)
        ->find($id);

        $em = $this->doctrine->getManager();
        $em->remove($guild);
        $em->flush();
    }


    public function acceptInvite($data)
    {
        $guildMember = $this->doctrine
            ->getRepository(\App\Entity\TFS12\GuildMembership::class)
        ->findOneBy(['player' => $data['playerId']]);

        if ( $guildMember !== NULL )
        {
            $player = $this->doctrine
                ->getRepository(\App\Entity\TFS12\Players::class)
            ->find($data['playerId']);

            $guild = $this->doctrine
                ->getRepository(\App\Entity\TFS12\Guilds::class)
            ->find($data['guildId']);

            $guildRank = $this->doctrine
                ->getRepository(\App\Entity\TFS12\GuildRanks::class)
            ->findOneBy(['guild' => $guild, 'level' => 1]);

            $guildMember->setGuild($guild)
                ->setPlayer($player)
            ->setRank($guildRank);

            $em = $this->doctrine->getManager();
            $em->persist($guildMember);
            $em->flush();
        }
        else
        {
            $player = $this->doctrine
                ->getRepository(\App\Entity\TFS12\Players::class)
            ->find($data['playerId']);

            $guild = $this->doctrine
                ->getRepository(\App\Entity\TFS12\Guilds::class)
            ->find($data['guildId']);

            $guildMember = new \App\Entity\TFS12\GuildMembership();

            $guildRank = $this->doctrine
                ->getRepository(\App\Entity\TFS12\GuildRanks::class)
            ->findOneBy(['guild' => $guild, 'level' => 1]);

            $guildMember->setGuild($guild)
                ->setPlayer($player)
            ->setRank($guildRank);

            $em = $this->doctrine->getManager();
            $em->persist($guildMember);
            $em->flush();
        }


    }


    public function leaveGuild($pId)
    {
        $guildMember = $this->doctrine
            ->getRepository(\App\Entity\TFS12\GuildMembership::class)
        ->findOneBy(['player' => $pId]);

        $em = $this->doctrine->getManager();
        $em->remove($guildMember);
        $em->flush();
    }


    public function isMember($pId)
    {
        $guildMember = $this->doctrine
            ->getRepository(\App\Entity\TFS12\GuildMembership::class)
        ->findOneBy(['player' => $pId]);

        if ( $guildMember !== NULL )
            return true;

        return false;
    }
    
}