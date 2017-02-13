<?php

namespace MyShop\AdminBundle\Controller;

use MyShop\DefBundle\Entity\PhotoForProduct;
use MyShop\DefBundle\Form\PhotoForProductType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Eventviva\ImageResize;
use MyShop\AdminBundle\Services\CheckingPhoto;

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
			$checkingPhoto=$this->get("myshop_admin.checking_photo");
			try{
				$checkingPhoto->check($photoFile);
			} catch(\InvalidArgumentException $ex){
				die("все,приплыли");
			}
			$generatorName=$this->get("myshop_admin.photo_name_generator");
			$namePhoto=$product->getId() . $generatorName->generateName() . $product->getId() . "." . $photoFile->getClientOriginalExtension();
			$photoDir=$this->get("kernel")->getRootDir() . "/../web/photos/";
			$photoFile->move($photoDir , $namePhoto);
            $img=new ImageResize($photoDir.$namePhoto);
            $img->resizeToBestFit(120,200);
            $smallName="small_photo_".$namePhoto;
            $img->save($photoDir.$smallName);
            $photo->setSmallFileName($smallName);
			$photo->setFileName($namePhoto);
			$photo->setProduct($product);
			$manager->persist($photo);
			$manager->flush();
			
			return $this->redirectToRoute("show_photo_for_product",["idProduct"=>$idProduct]);
		}
		
		return ["form"=>$form->createView(),"product"=>$product];

	}

	/**
	*@Template()
	*/
	public function updatePhotoAction(Request $request,$idPhoto)
	{
		$photo=$this->getDoctrine()->getRepository("MyShopDefBundle:PhotoForProduct")->find($idPhoto);
		$form=$this->createForm(PhotoForProductType::class,$photo);

		if ($request->isMethod("POST")) {
			$form->handleRequest($request);
			if ($form->isSubmitted()) {                               //переделать
				$manager=$this->getDoctrine()->getManager();
				$manager->persist($photo);
				$manager->flush();

				return $this->redirectToRoute("show");
			}
		}
		return ["form"=>$form->createView(),
				"photo"=>$photo];
	}


	public function deletePhotoAction($idPhoto)
	{
		$photo=$this->getDoctrine()->getRepository("MyShopDefBundle:PhotoForProduct")->find($idPhoto);
		$manager=$this->getDoctrine()->getManager();
		$manager->remove($photo);
		$manager->flush();

		return $this->redirectToRoute("show");//другой redirect

	}


}