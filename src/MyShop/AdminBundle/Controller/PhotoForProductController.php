<?php

namespace MyShop\AdminBundle\Controller;

use MyShop\AdminBundle\Services\PhotoDelete;
use MyShop\DefBundle\Entity\PhotoForProduct;
use MyShop\DefBundle\Form\PhotoForProductType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class PhotoForProductController extends MyController
{
	/**
	* @Template()
	*/
	public function showAction($idProduct)
	{
		$product=$this->getDoctrine()->getManager()->getRepository("MyShopDefBundle:Product")->find($idProduct);
		if($product==null)
        {
            $this->addFlash('error','Товар не найдена');
            return $this->redirectToRoute("show");
        }
		return ["product"=>$product];
	}

	/**
	* @Template()
	*/
	public function addPhotoAction(Request $request,$idProduct)
	{
		$manager=$this->getDoctrine()->getManager();
		$product=$manager->getRepository("MyShopDefBundle:Product")->find($idProduct);
		if ($product==null) {
            $this->addFlash('error','Товар не найдена');
            return $this->redirectToRoute("show");
        }
		$photo=new PhotoForProduct();
		$form=$this->createForm(PhotoForProductType::class,$photo);
		if ($request->isMethod("POST"))
		{
			$form->handleRequest($request);
            $data=$form->getData();
			if ($data->getMajorPhoto()==true)
			    $this->get('major_photo_service')->setMajorPhoto($idProduct);
            try{
                $this->get('myshop_admin.upload_photo')->uploadNewPhoto($request, $photo, $idProduct);
            } catch (\InvalidArgumentException $ex){
                $this->addFlash('error','Ошибка'.$ex->getMessage());
                return $this->redirectToRoute("add_photo_for_product",["idProduct"=>$idProduct]);
            }
			$photo->setProduct($product);
			$manager->persist($photo);
			$manager->flush();
			$name=$this->getDoctrine()->getRepository("MyShopDefBundle:Product")->find($idProduct);
			$model=$name->getModel();
            $message="Фотография добавленна к " . $model;
            $photoForMessage=$photo->getSmallFileName();
            $this->notification($message,$photoForMessage);
			return $this->redirectToRoute("show_photo_for_product",["idProduct"=>$idProduct]);
		}
		return ["form"=>$form->createView(),"product"=>$product];
	}

	public function updateMajorPhotoAjaxAction($idPhoto)
    {
        $photo=$this->getDoctrine()->getRepository("MyShopDefBundle:PhotoForProduct")->find($idPhoto);
        if ($photo==null) {
            $this->addFlash('error','Фотография не найдена');
            return $this->redirectToRoute("show");
        }
        $idProduct=$photo->getProduct()->getId();
        $manager=$this->getDoctrine()->getManager();
        $this->get('major_photo_service')->setMajorPhoto($idProduct,$photo->getId());
        $photo->setMajorPhoto(1);
        $manager->persist($photo);
        $manager->flush();
        return $this->json(['message'=>'Major photo updated']);
    }

	/**
	*@Template()
	*/
	public function updatePhotoAction(Request $request,$idPhoto)
	{
		$photo=$this->getDoctrine()->getRepository("MyShopDefBundle:PhotoForProduct")->find($idPhoto);
		$form=$this->createForm(PhotoForProductType::class,$photo);
        if ($photo==null) {
            $this->addFlash('error','Фотография не найдена');
            return $this->redirectToRoute("show");
        }
        if ($request->isMethod("POST")) {
			$form->handleRequest($request);
			if ($form->isSubmitted()) {
                $manager=$this->getDoctrine()->getManager();
                $idProduct=$photo->getProduct()->getId();
                $deleteFile=$this->get("myshop_admin.delete_photo");
                $deleteFile->deleteFile($photo->getFileName(),$photo->getMiniFileName(),$photo->getSmallFileName(),$photo->getBigFileName());
                $data=$form->getData();
                if ($data->getMajorPhoto()==true)
                    $this->get('major_photo_service')->setMajorPhoto($idProduct,$photo->getId());
                try{
                    $this->get('myshop_admin.upload_photo')->uploadNewPhoto($request, $photo, $idProduct);
                } catch (\InvalidArgumentException $ex){
                    $this->addFlash('error','Ошибка'.$ex->getMessage());
                    return $this->redirectToRoute("update_photo_for_product",['idPhoto'=>$idPhoto]);
                }
				$manager->persist($photo);
				$manager->flush();
                $name=$this->getDoctrine()->getRepository("MyShopDefBundle:Product")->find($idProduct);
                $model=$name->getModel();
                $message="Фотография товара " . $model . " обновленна.";
                $photoForMessage=$photo->getSmallFileName();
                $this->notification($message,$photoForMessage);
                return $this->redirectToRoute("show_photo_for_product",["idProduct"=>$idProduct]);
			}
		}
		return ["form"=>$form->createView(),
				"photo"=>$photo];
	}


	public function deletePhotoAction($idPhoto)
	{
		$photo=$this->getDoctrine()->getRepository("MyShopDefBundle:PhotoForProduct")->find($idPhoto);
		$manager=$this->getDoctrine()->getManager();
        if ($photo==null) {
            $this->addFlash('error','Фотография не найдена');
            return $this->redirectToRoute("show");
        }
        $deleteFile=$this->get("myshop_admin.delete_photo");
        $deleteFile->deleteFile($photo->getFileName(),$photo->getMiniFileName(),$photo->getSmallFileName(),$photo->getBigFileName());
		$manager->remove($photo);
		$manager->flush();
        $idProduct=$photo->getProduct()->getId();
        $name=$this->getDoctrine()->getRepository("MyShopDefBundle:Product")->find($idProduct);
        $model=$name->getModel();
        $message="Фотография " . $photo->getSmallFileName() . " товара " . $model . " была удалина.";
        $this->notification($message);
        return $this->redirectToRoute("show_photo_for_product",["idProduct"=>$idProduct]);

	}


}