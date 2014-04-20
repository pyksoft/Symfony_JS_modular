<?php

namespace ModulaR\modularBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\Query;

use ModulaR\modularBundle\Model\AdminModel;
use ModulaR\modularBundle\Model\AdminForm;
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
        $form = $this->getModuleForm($module);

        return $this->render('modularBundle:Admin:'.$module.'Single.html.twig', array(
            'module'  => AdminModel::getModule($module),
            'id'      => $id,
            'form'    => $form->createView()
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
        $ModuleClass = "ModulaR\\modularBundle\\Entity\\".$module."Module";
        $new = new $ModuleClass();

        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($new);
        $em->flush();
        return new Response($new->getId());
    }

    /**
     * @Route("/admin/save/{module}/{id}", name="admin-module-save")
     * @Template()
     */
    public function moduleSaveAction( Request $request , $module , $id )
    {

        $repo = $this->getDoctrine()->getRepository('modularBundle:'.$module.'Module');
        $data = $repo->find($id) ; 
        $form = $this->getModuleForm($module);

        $form->submit($request);



        //if( $form->isValid() ){
            $data->updateWithForm( $form );
            $data->setUpdated(new  \Datetime("now"));

            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($data);
            $em->flush();
            return new Response("ok");


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
        $em->remove($data);
        $em->flush();
        return new Response('ok');
    }

    /*
     * getForm helper
     */
    private function getModuleForm( $module ){

        $ModuleForm = $module."Form";
        $ModuleClass = "ModulaR\\modularBundle\\Entity\\".$module."Module";

        $form = AdminForm::$ModuleForm($this->createFormBuilder(new $ModuleClass() ));
        
        return $form->getForm();
    }


}
