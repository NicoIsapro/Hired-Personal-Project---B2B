<?php

namespace Website\WebBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Products
 *
 * @ORM\Table(name="products")
 * @ORM\Entity
 */
class Products
{
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="text", length=65535, nullable=false)
     */
    public $name;

    /**
     * @var float
     *
     * @ORM\Column(name="price", type="float", precision=10, scale=0, nullable=false)
     */
    public $price;

    /**
     * @var integer
     *
     * @ORM\Column(name="categid", type="integer", nullable=false)
     */
    public $categid;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", length=65535, nullable=false)
     */
    public $description;

    /**
     * @var string
     *
     * @ORM\Column(name="img", type="text", length=65535, nullable=true)
     */
    public $img;

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
      return $this->name;
    }

}

