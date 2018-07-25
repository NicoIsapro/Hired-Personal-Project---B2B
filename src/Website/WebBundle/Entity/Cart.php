<?php

namespace Website\WebBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Cart
 *
 * @ORM\Table(name="cart")
 * @ORM\Entity
 */
class Cart
{
    /**
     * @var integer
     *
     * @ORM\Column(name="prodid", type="integer", nullable=false)
     */
    private $prodid;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime", nullable=false)
     */
    private $created = 'CURRENT_TIMESTAMP';

    /**
     * @var integer
     *
     * @ORM\Column(name="userid", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $userid;
    public function __toString()
    {
      return $this->name;
    }

}

