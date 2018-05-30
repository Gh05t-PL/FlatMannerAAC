<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * News
 *
 * @ORM\Table(name="fmAAC_news")
 * @ORM\Entity
 */
class News
{

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=50, nullable=false)
     */
    private $title = '';


    /**
     * @var App\Entity\Players
     *
     * @ORM\OneToOne(targetEntity="App\Entity\Players")
     * @ORM\JoinColumn(name="`player_id`", referencedColumnName="id")
     */
    private $author;


    /**
     * @var int
     *
     * @ORM\Column(name="date", type="integer", length=11, nullable=false, options={"unsigned"=true})
     */
    private $date;


    /**
     * @var int
     *
     * @ORM\Column(name="text", type="text", nullable=false)
     */
    private $text;


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
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return App\Entity\Players
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param App\Entity\Players $author
     */
    public function setAuthor($author)
    {
        $this->author = $author;
    }

    /**
     * @return int
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param int $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @return int
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param int $text
     */
    public function setText($text)
    {
        $this->text = $text;
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
