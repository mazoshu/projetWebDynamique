<?php

namespace PJ\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use PJ\BlogBundle\Entity\Image;
use PJ\BlogBundle\Entity\Game;
use Doctrine\Common\Collections\ArrayCollection;
/**
 * Gallery
 *
 * @ORM\Table(name="gallery")
 * @ORM\Entity(repositoryClass="PJ\BlogBundle\Repository\GalleryRepository")
 */
class Gallery
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
     * @var Game
    * @ORM\OneToOne(targetEntity="PJ\BlogBundle\Entity\Game", inversedBy="gallery")
    */

     private $game;
     
     /**
      *
      * @var Image
      * @ORM\OneToMany(targetEntity="PJ\BlogBundle\Entity\Image", mappedBy="gallery",cascade={"all"})
      */
     private $images;

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
     * Constructor
     */
    public function __construct()
    {
        $this->images = new \Doctrine\Common\Collections\ArrayCollection();
    }

    


    /**
     * Set game
     *
     * @param \PJ\BlogBundle\Entity\Game $game
     *
     * @return Gallery
     */
    public function setGame(\PJ\BlogBundle\Entity\Game $game = null)
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

    /**
     * Add image
     *
     * @param \PJ\BlogBundle\Entity\Image $image
     *
     * @return Gallery
     */
    public function addImage(\PJ\BlogBundle\Entity\Image $image)
    {
        $this->images[] = $image;
        $image->setGallery($this);
        return $this;
    }

    /**
     * Remove image
     *
     * @param \PJ\BlogBundle\Entity\Image $image
     */
    public function removeImage(\PJ\BlogBundle\Entity\Image $image)
    {
        $this->images->removeElement($image);
    }

    /**
     * Get images
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getImages()
    {
        return $this->images;
    }
}
