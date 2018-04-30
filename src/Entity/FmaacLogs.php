<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FmaacLogs
 *
 * @ORM\Table(name="fmAAC_logs", indexes={@ORM\Index(name="action_id", columns={"action_id"})})
 * @ORM\Entity
 */
class FmaacLogs
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
     * @var \DateTime
     *
     * @ORM\Column(name="datetime", type="datetime", nullable=false)
     */
    private $datetime;

    /**
     * @var string
     *
     * @ORM\Column(name="ip", type="string", length=15, nullable=false)
     */
    private $ip;

    /**
     * @var \FmaacLogsActions
     *
     * @ORM\ManyToOne(targetEntity="FmaacLogsActions")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="action_id", referencedColumnName="id")
     * })
     */
    private $action;

    public function getDatetime(): ?\DateTimeInterface
    {
        return $this->datetime;
    }

    public function setDatetime(\DateTimeInterface $datetime): self
    {
        $this->datetime = $datetime;

        return $this;
    }

    public function getIp(): ?string
    {
        return $this->ip;
    }

    public function setIp(string $ip): self
    {
        $this->ip = $ip;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAction(): ?FmaacLogsActions
    {
        return $this->action;
    }

    public function setAction(?FmaacLogsActions $action): self
    {
        $this->action = $action;

        return $this;
    }


}
