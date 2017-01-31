<?php

namespace PJ\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use PJ\BlogBundle\Entity\Console;

/**
 * Game
 *
 * @ORM\Table(name="game")
 * @ORM\Entity(repositoryClass="PJ\BlogBundle\Repository\GameRepository")
 */
class Game
{
      /**

   * @ORM\ManyToMany(targetEntity="PJ\BlogBundle\Entity\Console", cascade={"persist"})

   */

  private $console;
     /**

   * @ORM\OneToMany(targetEntity="PJ\BlogBundle\Entity\Comment")
   */
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
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="year", type="string", length=255)
     */
    private $year;
    
    /**

   * @ORM\OneToOne(targetEntity="PJ\BlogBundle\Entity\Image", cascade={"persist"})

   */

  private $image;

   /**

   * @ORM\OneToOne(targetEntity="PJ\BlogBundle\Entity\Gallery", mappedBy="game", cascade={"persist"})
   * 

   */
  //@ORM\JoinColumn(nullable=false)
  private $gallery;
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
     * @return Game
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
     * @return Game
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
     * Set title
     *
     * @param string $title
     *
     * @return Game
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set year
     *
     * @param string $year
     *
     * @return Game
     */
    public function setYear($year)
    {
        $this->year = $year;

        return $this;
    }

    /**
     * Get year
     *
     * @return string
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * Set image
     *
     * @param \PJ\BlogBundle\Entity\Image $image
     *
     * @return Game
     */
    public function setImage(\PJ\BlogBundle\Entity\Image $image = null)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return \PJ\BlogBundle\Entity\Image
     */
    public function getImage()
    {
        return $this->image;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->galerie = new \Doctrine\Common\Collections\ArrayCollection();
    }

  


   

    /**
     * Set gallery
     *
     * @param \PJ\BlogBundle\Entity\Gallery $gallery
     *
     * @return Game
     */
    public function setGallery(\PJ\BlogBundle\Entity\Gallery $gallery)
    {
        $this->gallery = $gallery;
        $gallery->setGame($this);

        return $this;
    }

    /**
     * Get gallery
     *
     * @return \PJ\BlogBundle\Entity\Gallery
     */
    public function getGallery()
    {
        return $this->gallery;
    }

    

    

    /**
     * Add console
     *
     * @param \PJ\BlogBundle\Entity\Console $console
     *
     * @return Game
     */
    public function addConsole(\PJ\BlogBundle\Entity\Console $console)
    {
        $this->console[] = $console;

        return $this;
    }

    /**
     * Remove console
     *
     * @param \PJ\BlogBundle\Entity\Console $console
     */
    public function removeConsole(\PJ\BlogBundle\Entity\Console $console)
    {
        $this->console->removeElement($console);
    }

    /**
     * Get console
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getConsole()
    {
        return $this->console;
    }
}
