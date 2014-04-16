<?php

namespace ModulaR\modularBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PostModule
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="ModulaR\modularBundle\Entity\PostModuleRepository")
 */
class PostModule extends DataModule
{

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     */
    protected $content = "";

    /**
     * @var string
     *
     * @ORM\Column(name="state", type="text")
     */
    protected $state = "draft";

    /**
     * Set content
     *
     * @param string $content
     * @return Post
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string 
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set state
     *
     * @param string $state
     * @return Post
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Get state
     *
     * @return string 
     */
    public function getState()
    {
        return $this->state;
    }

    public function __construct(){
        parent::__construct();
        $this->setTitle("New post");
    }
}
