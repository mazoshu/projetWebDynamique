<?php

namespace PJ\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Console
 *
 * @ORM\Table(name="console")
 * @ORM\Entity(repositoryClass="PJ\BlogBundle\Repository\ConsoleRepository")
 */
class Console
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
     * @ORM\Column(name="name", type="string", length=255, nullable=true)
     */
    private $name;

//    /**
//     * @var string
//     *
//     * @ORM\Column(name="playstation", type="string", length=255, nullable=true)
//     */
//    private $playstation;
//
//    /**
//     * @var string
//     *
//     * @ORM\Column(name="xbox", type="string", length=255, nullable=true)
//     */
//    private $xbox;
//
//    /**
//     * @var string
//     *
//     * @ORM\Column(name="nintendo", type="string", length=255, nullable=true)
//     */
//    private $nintendo;

    


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
     * Set pc
     *
     * @param string $name
     *
     * @return Console
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set playstation
     *
     * @param string $playstation
     *
     * @return Console
     */
    /*public function setPlaystation($playstation)
    {
        $this->playstation = $playstation;

        return $this;
    }*/

    /**
     * Get playstation
     *
     * @return string
     */
    /*public function getPlaystation()
    {
        return $this->playstation;
    }*/

    /**
     * Set xbox
     *
     * @param string $xbox
     *
     * @return Console
     */
   /* public function setXbox($xbox)
    {
        $this->xbox = $xbox;

        return $this;
    }*/

    /**
     * Get xbox
     *
     * @return string
     */
   /* public function getXbox()
    {
        return $this->xbox;
    }*/

    /**
     * Set nintendo
     *
     * @param string $nintendo
     *
     * @return Console
     */
    /*public function setNintendo($nintendo)
    {
        $this->nintendo = $nintendo;

        return $this;
    }*/

    /**
     * Get nintendo
     *
     * @return string
     */
   /* public function getNintendo()
    {
        return $this->nintendo;
    }*/

 
}

