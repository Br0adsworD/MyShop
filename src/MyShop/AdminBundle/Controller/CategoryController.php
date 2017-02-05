<?php

namespace MyShop\AdminBundle\Controller;

use MyShop\DefBundle\Form\CategoryType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use MyShop\DefBundle\Entity\Category;

class CategoryController extends Controller
{
	/**
	*@Template()
	*/
    public function listAction()
    {
    	$categoryList=$this->getDoctrine()->getRepository("MyShopDefBundle:Category")->findAll();

        return ["categoryList"=>$categoryList];
    }

    /**
	*@Template()
	*/
    public function addAction(Request $request)
    {
    	$category=new Category();
    	$form=$this->createForm(CategoryType::class,$category);

    	if($request->isMethod("POST")) 
    	{
    		$form->handleRequest($request);
    		$manager=$this->getDoctrine()->getManager();
    		$manager->persist($category);
    		$manager->flush();
    		return $this->redirectToRoute("list_category");
    	}

        return ["form"=>$form->createView()];
    }



  
    public function deleteAction($id_category)
    {
    	$category=$this->getDoctrine()->getRepository("MyShopDefBundle:Category")->find($id_category);
		$manager=$this->getDoctrine()->getManager();
		$manager->remove($category);
		$manager->flush();

		return $this->redirectToRoute("list_category");
    }

}
