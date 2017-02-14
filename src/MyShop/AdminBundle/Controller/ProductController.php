<?php

namespace MyShop\AdminBundle\Controller;

use MyShop\DefBundle\Entity\Product;
use MyShop\DefBundle\Form\ProductType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;

class ProductController extends Controller
{
	/**
	*@Template()
	*/
	public function showAction()
	{
		$manager=$this->getDoctrine()->getManager();
        $repository=$manager->getRepository("MyShopDefBundle:Product");
        $productList=$repository->findAll();
        return ["productList"=>$productList];
    }

    public function listByCategoryAction($id_category)
    {
    	$category=$this->getDoctrine()->getRepository("MyShopDefBundle:Category")->find($id_category);
    	$productList=$category->getProductList();
        return $this->render("MyShopAdminBundle:Product:show.html.twig",["productList"=>$productList]);
    }
	
    
	public function deleteAction($id)
	{
		$product=$this->getDoctrine()->getRepository("MyShopDefBundle:Product")->find($id);
		$manager=$this->getDoctrine()->getManager();
		$manager->remove($product);
		$manager->flush();

        $this->addFlash('info','product deleted');

        $logger=$this->get("logger");
        $logger->addInfo("Удалили товар ".$product->getManufacturer(). " " . $product->getModel());

		return $this->redirectToRoute("show");
	}

	/**
	*@Template()
	*/
	public function updateAction(Request $request,$id)
	{
		$product=$this->getDoctrine()->getRepository("MyShopDefBundle:Product")->find($id);
        if ($product==null)
        {
            $this->addFlash('error','not found product');
            return $this->redirectToRoute("show");
        }
		$form=$this->createForm(ProductType::class,$product);

		if ($request->isMethod("POST")) {
			$form->handleRequest($request);
			if ($form->isSubmitted()) {
				$manager=$this->getDoctrine()->getManager();
				$manager->persist($product);
				$manager->flush();

                $logger=$this->get("logger");
                $logger->addInfo("Обновили товар ".$product->getManufacturer(). " " . $product->getModel());

                $this->addFlash('info','product updated');

				return $this->redirectToRoute("show");
			}
		}
		return ["form"=>$form->createView(),
				"product"=>$product];
	}


	/**
	*@Template()
	*/
	public function addAction(Request $request)
	{
		$product=new Product();
		$form=$this->createForm(ProductType::class,$product);

		if ($request->isMethod("POST")) {
			$form->handleRequest($request);
			if ($form->isSubmitted()) {
				$manager=$this->getDoctrine()->getManager();
				$manager->persist($product);
				$manager->flush();

				$logger=$this->get("logger");
				$logger->addInfo("Добавили товар ".$product->getManufacturer(). " " . $product->getModel());

                $this->addFlash('info','added product');

				return $this->redirectToRoute("show");
			}
		}

		$this->get('session')->set('history','add file');

		return ["form"=>$form->createView()];
	}


}