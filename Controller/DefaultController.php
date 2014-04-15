<?php

namespace ModulaR\modularBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    /**
     * @Route("/" , name="font-home")
     * @Template()
     */
    public function indexAction()
    {
        return array();
    }
}
