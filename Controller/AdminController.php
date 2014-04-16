<?php

namespace ModulaR\modularBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\Query;

use ModulaR\modularBundle\Model\AdminModel;
use ModulaR\modularBundle\Entity;

class AdminController extends Controller
{
        /**
     * @Route("/admin/" , name="admin-home")
     * @Template()
     */
    public function adminAction()
    {
        
        $lang = AdminModel::getLang();

        return array(
            'config'        => AdminModel::getConfig(),
            'modules'       => AdminModel::getModules(),
            'lang'          => AdminModel::getLang()
        );
    }

    /**
     * @Route("/admin/{module}/", name="admin-module")
     * @Template()
     */
    public function moduleAction($module)
    {
        //$repo = $this->getDoctrine()->getRepository('modularBundle:'.$module.'Module');
        return $this->render('modularBundle:Admin:'.$module.'.html.twig', array(
            //'data'      => json_encode($repo->findAll()),
            'module'    => AdminModel::getModule($module)
        ));
    }

    /**
     * @Route("/admin/single/{module}/{id}", name="admin-module-single")
     * @Template()
     */
    public function moduleSingleAction($module,$id)
    {
        //$em = $this->getDoctrine()->getEntityManager();
        $repo = $this->getDoctrine()->getRepository('modularBundle:PostModule');
        // $repo = $this->getDoctrine()->getRepository('modularBundle:'.$module.'Module');
        return $this->render('modularBundle:Admin:'.$module.'-single.html.twig', array(
            //'data'    => json_encode($repo->findArray($id))
            'data'    => json_encode($repo->findArray($id))
        ));
    }

    /**
     * @Route("/admin/get/{module}/{id}", name="admin-module-get")
     * @Template()
     */
    public function moduleGetAction($module,$id)
    {
        $repo = $this->getDoctrine()->getRepository('modularBundle:'.$module.'Module');
        return new Response(json_encode($repo->findArray($id)));

    }

    /**
     * @Route("/admin/getAll/{module}/", name="admin-module-getAll")
     * @Template()
     */
    public function moduleGetAllAction($module)
    {
        $repo = $this->getDoctrine()->getRepository('modularBundle:'.$module.'Module');
        return new Response(json_encode($repo->findAllArray()));
    }

    /**
     * @Route("/admin/create/{module}/", name="admin-module-create")
     * @Template()
     */
    public function moduleCreateAction($module)
    {
        $module = "ModulaR\\modularBundle\\Entity\\".$module."Module";
        $new = new $module();

        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($new);
        $em->flush();
        return new Response('ok');
    }

    /**
     * @Route("/admin/delete/{module}/{id}", name="admin-module-delete")
     * @Template()
     */
    public function moduleDeleteAction($module,$id)
    {
        $repo = $this->getDoctrine()->getRepository('modularBundle:'.$module.'Module');
        $data = $repo->find($id);
        if (!$data) throw $this->createNotFoundException('No data found with the id : ' . $id);

        $em = $this->getDoctrine()->getEntityManager();
        $data->remove();
        $em->flush();
        return new Response('ok');
    }

}
