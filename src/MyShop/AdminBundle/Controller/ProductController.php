<?php

namespace MyShop\AdminBundle\Controller;

use MyShop\AdminBundle\Services\SendingLetters;
use MyShop\DefBundle\Entity\Product;
use MyShop\DefBundle\Form\ProductType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\ConstraintViolationList;

class ProductController extends MyController
{
	/**
	*@Template()
	*/
	public function showAction()
	{
        $productList=$this->getDoctrine()->getManager()->getRepository("MyShopDefBundle:Product")->findAll();

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
	
    
	public function deleteAction(Product $product)
	{
		$manager=$this->getDoctrine()->getManager();
        if ($product==null)
        {
            $this->addFlash('error','Товар не найден');
            return $this->redirectToRoute("show");
        }
		$manager->remove($product);
		$manager->flush();

        $message="Удалили товар " . $product->getManufacturer(). " " . $product->getModel();
        $this->notification($message);

		return $this->redirectToRoute("show");
	}

	/**
	*@Template()
	*/
	public function updateAction(Request $request,Product $product)
	{
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
				$this->notification($message);
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
			    /** @var ConstraintViolationList $errorArray */
                $errorArray=$this->get("validator")->validate($product);
                if ($errorArray->count()>0)
                {
                    foreach ($errorArray as $message)
                    {
                        $this->addFlash('error',$message->getMessage());
                    }
                    return $this->redirectToRoute("admin_add");
                }
                $filesArray=$request->files->get("myshop_defbundle_product");
                /**
                * @var UploadedFile $photoFile
                */
                $photoFile=$filesArray["iconPhoto"];
                $checkingPhoto=$this->get("myshop_admin.checking_photo");
                try{
                    $checkingPhoto->check($photoFile);
                } catch(\InvalidArgumentException $ex){
                    $this->addFlash('error','Тип фйла не верный');
                    return $this->redirectToRoute("show");
                }
                $results=$this->get("myshop_admin.upload_photo")->uploadIcon($photoFile);
                $product->setIconFile($results);
                $manager=$this->getDoctrine()->getManager();
				$manager->persist($product);
				$manager->flush();

                $message="Добавили товар " . $product->getManufacturer(). " " . $product->getModel();
                $this->notification($message);

                return $this->redirectToRoute("show");
			}
		}

		$this->get('session')->set('history', 'add file');

		return ["form"=>$form->createView()];
	}


}