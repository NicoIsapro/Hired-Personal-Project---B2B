<?php

namespace Website\WebBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AdminUsers
 *
 * @ORM\Table(name="admin_users")
 * @ORM\Entity
 */
class AdminUsers
{
    /**
     * @var string
     *
     * @ORM\Column(name="username", type="text", length=65535, nullable=false)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="text", length=65535, nullable=false)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="text", length=65535, nullable=false)
     */
    private $name;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;
    public function __toString()
    {
      return $this->name;
    }

}

