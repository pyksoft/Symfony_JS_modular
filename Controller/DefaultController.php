<?php

namespace ModulaR\modularBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    private $_postPerPage = 1;

    /**
     * @Route("/" , name="font-home")
     * @Template()
     */
    public function indexAction()
    {
        return $this->pageAction(1);
    }

    /**
     * @Route("/page/{page}" , name="font-page")
     * @Template()
     */
    public function pageAction($page)
    {

        $repo = $this->getDoctrine()->getRepository('modularBundle:PostModule');
        $articles_total = count($repo->findAll());
        return $this->render('modularBundle:Default:index.html.twig', array(
            'articles'          => $repo->findBy(array(), null, $this->_postPerPage, ($page-1)*$this->_postPerPage ),
            'articles_total'    => $articles_total,
            'articles_current'  => $page,
            'articles_prev'     => max( $page -1 , 1 ),
            'articles_next'     => min( $page +1 , $articles_total )
        ));
    }
}