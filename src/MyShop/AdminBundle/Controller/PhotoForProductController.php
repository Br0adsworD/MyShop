<?php

namespace MyShop\AdminBundle\Controller;

use MyShop\DefBundle\Entity\PhotoForProduct;
use MyShop\DefBundle\Form\PhotoForProductType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class PhotoForProductController extends Controller
{
	/**
	* @Template()
	*/
	public function showAction($idProduct)
	{
		$product=$this->getDoctrine()->getManager()->getRepository("MyShopDefBundle:Product")->find($idProduct);

		return ["product"=>$product];
	}

	/**
	* @Template()
	*/
	public function addPhotoAction(Request $request,$idProduct)
	{
		$manager=$this->getDoctrine()->getManager();
		$product=$manager->getRepository("MyShopDefBundle:Product")->find($idProduct);
		if ($product==null)
			return $this->createNotFoundException("Товар не найден");
		$photo=new PhotoForProduct();
		$form=$this->createForm(PhotoForProductType::class,$photo);
		if ($request->isMethod("POST"))
		{
			$form->handleRequest($request);
			$filesArray=$request->files->get("myshop_defbundle_photoforproduct");
			/*
			* @var UploadedFile $photoFile 
			*/
			$photoFile=$filesArray["photoFile"];
			$mimeType=$photoFile->getClientMimeType();
			if($mimeType!=="image/jpg" and $mimeType!=="image/gif" and $mimeType!=="image/png")
				throw new \InvalidArgumentException("Нельзя!");
			$fileExtension=$photoFile->getClientOriginalExtension();
			if($fileExtension!=="jpg" and $fileExtension!=="gif" and $fileExtension!=="png")
				throw new \InvalidArgumentException("Нельзя ");
			$namePhoto=$product->getId() . rand(1,999999999) . $product->getId() . "." . $photoFile->getClientOriginalExtension();
			$photoDir=$this->get("kernel")->getRootDir() . "/../web/photos/";
			$photoFile->move($photoDir . $namePhoto);
			$photo->setFileName($namePhoto);
			$photo->setProduct($product);
			$manager->persist($photo);
			$manager->flush();
			return $this->redirectToRoute("show");
			 // return $this->redirectToRoute("show_photo_for_product",["idProduct"=>$idProduct]);
		}
		
		return ["form"=>$form->createView(),"product"=>$product];

	}

	public function deletePhotoAction($FileName)
	{
		$photo=$this->getDoctrine()->getRepository("MyShopDefBundle:PhotoForProduct")->find($FileName);
		$manager=$this->getDoctrine()->getManager();
		$manager->remove($photo);
		$manager->flush();

		return $this->redirectToRoute("show");
	}
}