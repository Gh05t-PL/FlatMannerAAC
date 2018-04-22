<?php

namespace App\Acme\TestBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Bans
 *
 * @ORM\Table(name="bans", indexes={@ORM\Index(name="type", columns={"type", "value"}), @ORM\Index(name="active", columns={"active"})})
 * @ORM\Entity
 */
class Bans
{
    /**
     * @var bool
     *
     * @ORM\Column(name="type", type="boolean", nullable=false, options={"comment"="1 - ip banishment, 2 - namelock, 3 - account banishment, 4 - notation, 5 - deletion"})
     */
    private $type;

    /**
     * @var int
     *
     * @ORM\Column(name="value", type="integer", nullable=false, options={"unsigned"=true,"comment"="ip address (integer), player guid or account number"})
     */
    private $value;

    /**
     * @var int
     *
     * @ORM\Column(name="param", type="integer", nullable=false, options={"default"="4294967295","unsigned"=true,"comment"="used only for ip banishment mask (integer)"})
     */
    private $param = '4294967295';

    /**
     * @var bool
     *
     * @ORM\Column(name="active", type="boolean", nullable=false, options={"default"="1"})
     */
    private $active = '1';

    /**
     * @var int
     *
     * @ORM\Column(name="expires", type="integer", nullable=false)
     */
    private $expires;

    /**
     * @var int
     *
     * @ORM\Column(name="added", type="integer", nullable=false, options={"unsigned"=true})
     */
    private $added;

    /**
     * @var int
     *
     * @ORM\Column(name="admin_id", type="integer", nullable=false, options={"unsigned"=true})
     */
    private $adminId = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="comment", type="text", length=65535, nullable=false)
     */
    private $comment;

    /**
     * @var int
     *
     * @ORM\Column(name="reason", type="integer", nullable=false, options={"unsigned"=true})
     */
    private $reason = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="action", type="integer", nullable=false, options={"unsigned"=true})
     */
    private $action = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="statement", type="string", length=255, nullable=false)
     */
    private $statement = '';

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;


}
