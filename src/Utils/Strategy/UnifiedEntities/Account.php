<?php
/**
 * Created by PhpStorm.
 * User: wiktor
 * Date: 18.11.2018
 * Time: 13:56
 */

namespace App\Utils\Strategy\UnifiedEntities;


class Account
{
    private $id = null;
    private $name = null;
    private $password = null;
    private $groupId = null;
    private $points = null;


    public function __construct(int $id = null)
    {
        $this->id = $id;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return Account
     */
    public function setId(?int $id): Account
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Account
     */
    public function setName(string $name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @return Account
     */
    public function setPassword(string $password)
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getGroupId(): ?int
    {
        return $this->groupId;
    }

    /**
     * @param null|int $groupId
     * @return Account
     */
    public function setGroupId($groupId): Account
    {
        $this->groupId = $groupId;
        return $this;
    }

    /**
     * @param null|int $points
     * @return Account
     */
    public function setPoints($points)
    {
        $this->points = $points;
        return $this;
    }

    /**
     * @return null|int
     */
    public function getPoints()
    {
        return $this->points;
    }


}