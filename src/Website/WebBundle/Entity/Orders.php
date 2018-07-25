<?php

namespace Website\WebBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Orders
 *
 * @ORM\Table(name="orders")
 * @ORM\Entity
 */
class Orders
{
    /**
     * @var integer
     *
     * @ORM\Column(name="prodid", type="integer", nullable=false)
     */
    public $prodid;

    /**
     * @var integer
     *
     * @ORM\Column(name="categid", type="integer", nullable=false)
     */
    public $categid;

    /**
     * @var integer
     *
     * @ORM\Column(name="userid", type="integer", nullable=false)
     */
    private $userid;

    /**
     * @var integer
     *
     * @ORM\Column(name="status", type="integer", nullable=false)
     */
    public $status;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime", nullable=false)
     */
    public $date = 'CURRENT_TIMESTAMP';

    /**
     * @var string
     *
     * @ORM\Column(name="company", type="text", length=65535, nullable=false)
     */
    public $company;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    public $id;

    public function __toString()
    {
      return $this->date;
    }
}

