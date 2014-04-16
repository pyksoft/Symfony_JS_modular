<?php

namespace ModulaR\modularBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Data
 *
 * @ORM\MappedSuperclass
 */
class DataModule extends Module
{

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=100)
     */
    protected $title ="";

    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=100)
     */
    protected $slug = "";

    /**
     * @var integer
     *
     * @ORM\Column(name="id_user", type="integer")
     */
    protected $id_user = 0;

    /**
     * Set title
     *
     * @param string $title
     * @return Data
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return Data
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string 
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set id_user
     *
     * @param integer $iduser
     * @return Data
     */
    public function setIdUser($iduser)
    {
        $this->id_user = $iduser;

        return $this;
    }

    /**
     * Get id_user
     *
     * @return integer 
     */
    public function getIdUser()
    {
        return $this->id_user;
    }

    public function __construct(){
        parent::__construct();
    }
}
