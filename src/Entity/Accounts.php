<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Accounts
 *
 * @ORM\Table(name="accounts", uniqueConstraints={@ORM\UniqueConstraint(name="name", columns={"name"})})
 * @ORM\Entity
 */
class Accounts
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=32, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=40, nullable=false, options={"fixed"=true})
     */
    private $password;

    /**
     * @var int
     *
     * @ORM\Column(name="type", type="integer", nullable=false, options={"default"="1"})
     */
    private $type = '1';

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
     * @var int
     *
     * @ORM\Column(name="creation", type="integer", nullable=false)
     */
    private $creation = '0';

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getType(): ?int
    {
        return $this->type;
    }

    public function setType(int $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getPremdays(): ?int
    {
        return $this->premdays;
    }

    public function setPremdays(int $premdays): self
    {
        $this->premdays = $premdays;

        return $this;
    }

    public function getLastday(): ?int
    {
        return $this->lastday;
    }

    public function setLastday(int $lastday): self
    {
        $this->lastday = $lastday;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getCreation(): ?int
    {
        return $this->creation;
    }

    public function setCreation(int $creation): self
    {
        $this->creation = $creation;

        return $this;
    }


}
