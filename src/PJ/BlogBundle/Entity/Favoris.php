<?php

namespace PJ\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Favoris
 *
 * @ORM\Table(name="favoris")
 * @ORM\Entity(repositoryClass="PJ\BlogBundle\Repository\FavorisRepository")
 */
class Favoris
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
     * @ORM\Column(name="username", type="string", length=255)
     */
    private $username;
    
     /**

   * @ORM\ManyToOne(targetEntity="PJ\BlogBundle\Entity\Game", inversedBy="Favoris")
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
     * Set username
     *
     * @param string $username
     *
     * @return Favoris
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }



    /**
     * Set game
     *
     * @param \PJ\BlogBundle\Entity\Game $game
     *
     * @return Favoris
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
