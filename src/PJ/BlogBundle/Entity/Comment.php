<?php

namespace PJ\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Comment
 *
 * @ORM\Table(name="comment")
 * @ORM\Entity(repositoryClass="PJ\BlogBundle\Repository\CommentRepository")
 */
class Comment
{

    
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="author", type="string", length=255)
     */
    private $author;

    

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     */
    private $content;

   

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;
   
    
    /**

   * @ORM\ManyToOne(targetEntity="PJ\BlogBundle\Entity\Game", inversedBy="Comment")
     * @ORM\JoinColumn(name="game", referencedColumnName="id", nullable=false)
   */
    private $game;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set author
     *
     * @param string $author
     *
     * @return Comment
     */
    public function setAuthor($author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return string
     */
    public function getAuthor()
    {
        return $this->author;
    }

    

    /**
     * Set content
     *
     * @param string $content
     *
     * @return Comment
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    
    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Comment
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }
     public function __construct()
  {
    $this->date = new \Datetime();
  }


    /**
     * Set game
     *
     * @param \PJ\BlogBundle\Entity\Game $game
     *
     * @return Comment
     */
    public function setGame(\PJ\BlogBundle\Entity\Game $game)
    {
        $this->game = $game;

        return $this;
    }

    /**
     * Get game
     *
     * @return \PJ\BlogBundle\Entity\Game
     */
    public function getGame()
    {
        return $this->game;
    }


}
