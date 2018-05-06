<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
//a
/**
 * Accounts
 *
 * @ORM\Table(name="accounts", uniqueConstraints={@ORM\UniqueConstraint(name="name", columns={"name"})})
 * @ORM\Entity
 */
class Accounts
{
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=32, nullable=false)
     */
    private $name = '';

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255, nullable=false)
     */
    private $password;

    /**
     * @var int
     *
     * @ORM\Column(name="premdays", type="integer", nullable=false)
     */
    private $premdays = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="lastday", type="integer", nullable=false, options={"unsigned"=true})
     */
    private $lastday = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=false)
     */
    private $email = '';

    /**
     * @var string
     *
     * @ORM\Column(name="`key`", type="string", length=20, nullable=false)
     */
    private $key = '0';

    /**
     * @var bool
     *
     * @ORM\Column(name="blocked", type="boolean", nullable=false, options={"comment"="internal usage"})
     */
    private $blocked = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="warnings", type="integer", nullable=false)
     */
    private $warnings = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="group_id", type="integer", nullable=false, options={"default"="1"})
     */
    private $groupId = '1';

    /**
     * @var int
     *
     * @ORM\Column(name="points", type="integer", length=10, nullable=false, options={"default"="0"})
     */
    private $points = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

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
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return int
     */
    public function getPremdays()
    {
        return $this->premdays;
    }

    /**
     * @param int $premdays
     */
    public function setPremdays($premdays)
    {
        $this->premdays = $premdays;
    }

    /**
     * @return int
     */
    public function getLastday()
    {
        return $this->lastday;
    }

    /**
     * @param int $lastday
     */
    public function setLastday($lastday)
    {
        $this->lastday = $lastday;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @param string $key
     */
    public function setKey($key)
    {
        $this->key = $key;
    }

    /**
     * @return bool
     */
    public function isBlocked()
    {
        return $this->blocked;
    }

    /**
     * @param bool $blocked
     */
    public function setBlocked($blocked)
    {
        $this->blocked = $blocked;
    }

    /**
     * @return int
     */
    public function getWarnings()
    {
        return $this->warnings;
    }

    /**
     * @param int $warnings
     */
    public function setWarnings($warnings)
    {
        $this->warnings = $warnings;
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
    public function getPoints()
    {
        return $this->points;
    }

    /**
     * @param int $points
     */
    public function setPoints($points)
    {
        $this->points = $points;
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




    
}
