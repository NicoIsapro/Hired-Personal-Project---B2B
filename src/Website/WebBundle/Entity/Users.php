<?php

namespace Website\WebBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Users
 *
 * @ORM\Table(name="users")
 * @ORM\Entity
 * @UniqueEntity(fields={"email", "username"}, message="This one is already taker")
 */
class Users implements UserInterface, \Serializable
{
    /**
     * @var string
     *
     * @ORM\Column(name="company", type="text", length=65535, nullable=true)
     */
     public $company;
    /**
     * @var string
     *
     * @ORM\Column(name="roles", type="text", length=65535, nullable=false)
     */
    public $roles;

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="text", length=65535, nullable=false)
     */
    public $username;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="text", length=65535, nullable=false)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="surname", type="text", length=65535, nullable=false)
     */
    public $surname;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="text", length=65535, nullable=false)
     */
    public $name;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="text", length=65535, nullable=false)
     */
    public $email;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime", nullable=false)
     */
    private $created = 'CURRENT_TIMESTAMP';

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;
    public function __construct()
    {
      $this->isActive = true;
    // may not be needed, see section on salt below
    // $this->salt = md5(uniqid('', true));
    }

    public function getUsername()
    {
      return $this->username;
    }

    public function getSalt()
    {
    // you *may* need a real salt depending on your encoder
    // see section on salt below
      return null;
    }

    public function getPassword()
    {
      return $this->password;
    }
    public function getSurname()
    {
      return $this->surname;
    }
    public function setPassword($password)
    {
      $this->password = $password;
     }
     public function setUsername($username)
     {
         $this->username = $username;
     }
     public function setName($name)
     {
         $this->name = $name;
     }
     public function setSurname($surname)
     {
         $this->surname = $surname;
     }
     public function setDate($date)
     {
         $this->created = $date;
     }
     public function setRoles($roles)
     {
         $this->roles = $roles;
     }
     public function setEmail($email)
     {
         $this->email = $email;
     }
    public function getRoles()
    {
      return array($this->roles);
    }

    public function eraseCredentials()
    {
    }

    /** @see \Serializable::serialize() */
    public function serialize()
    {
      return serialize(array(
          $this->id,
          $this->username,
          $this->password,
        // see section on salt below
        // $this->salt,
    ));
    }

/** @see \Serializable::unserialize() */
    public function unserialize($serialized)
    {
      list (
          $this->id,
          $this->username,
          $this->password,
          // see section on salt below
          // $this->salt
          ) = unserialize($serialized, array('allowed_classes' => false));
    }
    public function __toString()
    {
      return $this->name;
    }
}
