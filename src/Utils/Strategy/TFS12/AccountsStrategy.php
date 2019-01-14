<?php

namespace App\Utils\Strategy\TFS12;


use App\Utils\Configs;
use Doctrine\ORM\Query\ResultSetMapping;

class AccountsStrategy implements \App\Utils\Strategy\IAccountsStrategy
{

    private $doctrine;

    public function __construct($doctrine)
    {
        $this->doctrine = $doctrine;
    }


    public function getAccountById($id)
    {
        $account = $this->doctrine
            ->getRepository(\App\Entity\TFS12\Accounts::class)
            ->find($id);

        return $account;
    }


    public function getAccountChars($id)
    {
        $chars = $this->doctrine
            ->getRepository(\App\Entity\TFS12\Players::class)
            ->findBy(['account' => $id]);

        return $chars;
    }


    public function getAccountBy($criteria)
    {
        $account = $this->doctrine
            ->getRepository(\App\Entity\TFS12\Accounts::class)
            ->findOneBy($criteria);

        return $account;
    }


    public function getNoGuildPlayers($accId)
    {
        $charsTemp = $this->doctrine->getRepository(\App\Entity\TFS12\Players::class)->findBy(['account' => $accId]);
        $chars = [];

        foreach ($charsTemp as $key => $value)
        {
            if ( $this->doctrine
                    ->getRepository(\App\Entity\TFS12\GuildMembership::class)
                    ->findBy(['player' => $value->getId()]) == null
            )
                $chars[$value->getName()] = $value->getId();
        }
        $charsTemp = null;
        return $chars;
    }


    public function changeAccountDetails($accId, $changes)
    {
        $account = $this->doctrine
            ->getRepository(\App\Entity\TFS12\Accounts::class)
            ->find($accId);

        if ( !empty($changes['password']) )
            $account->setPassword($this->encodePassword($changes['password']));
        if ( !empty($changes['email']) )
            $account->setEmail($changes['email']);

        $em = $this->doctrine->getManager();
        $em->persist($account);
        $em->flush();
    }

    private function encodePassword(string $password): string
    {
        if ( Configs::$config['passwordHashing'] === "plain" )
            return $password;
        return \hash(Configs::$config['passwordHashing'], $password);
    }

    public function createCharacter($formData, $accId, $cfg)
    {
        $player = new \App\Entity\TFS12\Players();

        $player->setName(ucwords(strtolower($formData['name'])));
        $player->setSex($formData['sex']);
        $player->setVocation($formData['vocation']);
        $player->setAccount($this->doctrine->getRepository(\App\Entity\TFS12\Accounts::class)->find($accId));
        $player->setLevel($cfg['startStats']['level']);
        $player->setCap($cfg['startStats']['cap']);
        $player->setMaglevel($cfg['startStats']['magiclevel']);
        $player->setHealth($cfg['startStats']['health']);
        $player->setHealthmax($cfg['startStats']['health']);
        $player->setMana($cfg['startStats']['mana']);
        $player->setManamax($cfg['startStats']['mana']);

        $player->setTownId($formData['city']);
        $player->setPosx($cfg['citiesPos'][$formData['city']]['x']);
        $player->setPosy($cfg['citiesPos'][$formData['city']]['y']);
        $player->setPosz($cfg['citiesPos'][$formData['city']]['z']);

        function expToLevel($level)
        {
            return ((50 * ($level - 1) ** 3 - 150 * ($level - 1) ** 2 + 400 * ($level - 1)) / 3);
        }

        $player->setExperience(expToLevel($cfg['startStats']['level']));

        //SKILLS
        $player->setSkillFist($cfg['startStats']['skill'])
            ->setSkillClub($cfg['startStats']['skill'])
            ->setSkillSword($cfg['startStats']['skill'])
            ->setSkillAxe($cfg['startStats']['skill'])
            ->setSkillDist($cfg['startStats']['skill'])
            ->setSkillShielding($cfg['startStats']['skill'])
            ->setSkillFishing($cfg['startStats']['skill']);

        $em = $this->doctrine->getManager();
        $em->persist($player);
        // SAVE PLAYER
        $em->flush();


        //today exp
        $conn = $em->getConnection();
        $conn->insert('today_exp', [
            'id' => null,
            'exp' => expToLevel($cfg['startStats']['level']),
            'player_id' => $player->getId(),
        ]);
    }

    public function createAccount($formData)
    {
        $account = new \App\Entity\TFS12\Accounts();
        $account->setName($formData['account']);
        $account->setPassword($this->encodePassword($formData['password']));
        $account->setEmail($formData['email']);
        $em = $this->doctrine->getManager();

        $em->persist($account);
        $em->flush();
    }

    /**
     * CHECKERS
     */
    public function isPlayerName($name)
    {
        if ( $this->doctrine->getRepository(\App\Entity\TFS12\Players::class)->findOneBy(['name' => $name]) !== null )
            return true;

        return false;
    }

}