<?php

namespace Website\WebBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * WebConfig
 *
 * @ORM\Table(name="web_config")
 * @ORM\Entity
 */
class WebConfig
{
    /**
     * @var string
     *
     * @ORM\Column(name="web_title", type="text", length=65535, nullable=false)
     */
    private $webTitle;

    /**
     * @var string
     *
     * @ORM\Column(name="tags", type="text", length=65535, nullable=false)
     */
    private $tags;

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
        return $this->webTitle;
      }

    /**
     * Set webTitle
     *
     * @param string $webTitle
     *
     * @return WebConfig
     */
    public function setWebTitle($webTitle)
    {
        $this->webTitle = $webTitle;

        return $this;
    }

    /**
     * Get webTitle
     *
     * @return string
     */
    public function getWebTitle()
    {
        return $this->webTitle;
    }

    /**
     * Set tags
     *
     * @param string $tags
     *
     * @return WebConfig
     */
    public function setTags($tags)
    {
        $this->tags = $tags;

        return $this;
    }

    /**
     * Get tags
     *
     * @return string
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $phone;

    /**
     * @var string
     */
    private $address;


    /**
     * Set email
     *
     * @param string $email
     *
     * @return WebConfig
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set phone
     *
     * @param string $phone
     *
     * @return WebConfig
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set address
     *
     * @param string $address
     *
     * @return WebConfig
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }
}
