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
         //$em = $this->getDoctrine()->getEntityManager();
        $repo = $this->getDoctrine()->getRepository('modularBundle:PostModule');
        // $repo = $this->getDoctrine()->getRepository('modularBundle:'.$module.'Module');

        return $this->render('modularBundle:Admin:Post-single.html.twig', array(
            //'data'    => json_encode($repo->findArray($id))
            'data'    => $repo->findArray(1)
        ));
    }
}