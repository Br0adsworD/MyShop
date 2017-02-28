<?php

namespace MyShop\AdminBundle\Controller;

use MyShop\AdminBundle\Services\SendingLetters;
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
        if ($category==null)
        {
            $this->addFlash('error','Такой категории не существует');
            return $this->redirectToRoute("show");
        }
    	$productList=$category->getProductList();
        return $this->render("MyShopAdminBundle:Product:show.html.twig",["productList"=>$productList]);
    }
	
    
	public function deleteAction($id)
	{
		$product=$this->getDoctrine()->getRepository("MyShopDefBundle:Product")->find($id);
		$manager=$this->getDoctrine()->getManager();
        if ($product==null)
        {
            $this->addFlash('error','Товар не найден');
            return $this->redirectToRoute("show");
        }
		$manager->remove($product);
		$manager->flush();
        $this->addFlash('info','Товар удален');
        $logger=$this->get("logger");
        $logger->addInfo("Удалили товар " . $product->getManufacturer() . " " . $product->getModel());

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
            $this->addFlash('error','Товар не найден');
            return $this->redirectToRoute("show");
        }
		$form=$this->createForm(ProductType::class,$product);
        if ($request->isMethod("POST")) {
			$form->handleRequest($request);
			if ($form->isSubmitted()) {
				$manager=$this->getDoctrine()->getManager();
				$manager->persist($product);
				$manager->flush();

				$message="Обновили товар " . $product->getManufacturer(). " " . $product->getModel();
				$mail=$this->get("myshop_admin.sending_letters");
                $userEmail=$this->getUser()->getEmail();
				$letter=$mail->sendLetter($userEmail,$message);
				$mailer=$this->get('mailer');
				$mailer->send($letter);
                $logger=$this->get("logger");
                $logger->addInfo($message);
                $this->addFlash('info', $message);
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
				$logger->addInfo("Добавили товар " . $product->getManufacturer() . " " . $product->getModel());
                $this->addFlash('info','Товар добавлен');
                return $this->redirectToRoute("show");
			}
		}

		$this->get('session')->set('history', 'add file');

		return ["form"=>$form->createView()];
	}


}