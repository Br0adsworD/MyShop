<?php

namespace MyShop\AdminBundle\Controller;


use MyShop\DefBundle\Entity\Pages;
use MyShop\DefBundle\Form\PagesType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

class PagesController extends MyController
{
    /**
     * @Template()
    */
    public function showPagesAction()
    {
        $pageList=$this->getDoctrine()->getRepository('MyShopDefBundle:Pages')->findAll();
        return ['pageList'=>$pageList];
    }

    /**
     * @Template()
     */
    public function addPageAction(Request $request)
    {
        $page=new Pages();
        $form=$this->createForm(PagesType::class,$page);
        if($request->isMethod('POST'))
        {
            $form->handleRequest($request);
            $manager=$this->getDoctrine()->getManager();
            $manager->persist($page);
            $manager->flush();
            $message='Страница добавлена';
            $this->notification($message);
            return $this->redirectToRoute('show');
        }
        return['form'=>$form->createView()];
    }

    /**
     * @Template()
     */
    public function updatePageAction(Request $request,Pages $page)
    {
        $form=$this->createForm(PagesType::class,$page);
        if($request->isMethod('POST'))
        {
            $form->handleRequest($request);
            $manager=$this->getDoctrine()->getManager();
            $manager->persist($page);
            $manager->flush();
            $message='Страница добавлена';
            $this->notification($message);
            return $this->redirectToRoute('show');
        }
        return['form'=>$form->createView(),'page'=>$page];
    }

    /**
     * @Template()
     */
    public function deletePageAction(Pages $pages)
    {
        $manager=$this->getDoctrine()->getManager();
        if ($pages==null)
        {
            $this->addFlash('error','Страница не найдена');
            return $this->redirectToRoute("show");
        }
        $manager->remove($pages);
        $manager->flush();

        $message='Страница "'.$pages->getTitle().'" была удалена';
        $this->notification($message);

        return $this->redirectToRoute("show");
    }
}