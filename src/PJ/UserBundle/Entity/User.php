<?php

namespace PJ\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="PJ\UserBundle\Repository\UserRepository")
 */
class User extends  BaseUser
{
  /**

   * @ORM\Column(name="id", type="integer")

   * @ORM\Id

   * @ORM\GeneratedValue(strategy="AUTO")

   */

  protected $id;
  
  /**
     * @var string
     *
     * @ORM\Column(name="presentation", type="string", length=255,nullable=true)
     */
    private $presentation;

    /**
     * Set presentation
     *
     * @param string $presentation
     *
     * @return User
     */
    public function setPresentation($presentation)
    {
        $this->presentation = $presentation;

        return $this;
    }

    /**
     * Get presentation
     *
     * @return string
     */
    public function getPresentation()
    {
        return $this->presentation;
    }


}
