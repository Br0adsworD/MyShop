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
    public function addAction(Request $request,$idParent= null)
    {
    	$category=new Category();
    	$form=$this->createForm(CategoryType::class,$category);

    	if($request->isMethod("POST")) 
    	{
    		$form->handleRequest($request);
    		$manager=$this->getDoctrine()->getManager();
    		if($idParent!==null)
            {
                $parentCategory = $this->getDoctrine()->getRepository("MyShopDefBundle:Category")->find($idParent);
                $category->setParentCategory($parentCategory);
            }
    		$manager->persist($category);
    		$manager->flush();

            $this->addFlash('info','category added');

    		return $this->redirectToRoute("show");
    	}

        return ["form"=>$form->createView(),"idParent"=>$idParent];
    }

    /**
    *@Template()
    */
    public function updateCategoryAction(Request $request,$id_category)
    {
        $category=$this->getDoctrine()->getRepository("MyShopDefBundle:Category")->find($id_category);
        $form=$this->createForm(CategoryType::class,$category);

        if ($request->isMethod("POST")) {
            $form->handleRequest($request);
            if ($form->isSubmitted()) {
                $manager=$this->getDoctrine()->getManager();
                $manager->persist($category);
                $manager->flush();

                $this->addFlash('info','category updated');

                return $this->redirectToRoute("show");
            }
        }
        return ["form"=>$form->createView(),
                "category"=>$category];
    }
  
    public function deleteAction($id_category)
    {
    	$category=$this->getDoctrine()->getRepository("MyShopDefBundle:Category")->find($id_category);
		$manager=$this->getDoctrine()->getManager();
		$manager->remove($category);
		$manager->flush();

        $this->addFlash('info','category deleted');

		return $this->redirectToRoute("show");
    }

}
