<?php

namespace MyShop\AdminBundle\Controller;

use MyShop\AdminBundle\Services\PhotoDelete;
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
		if ($product==null) {
            $this->addFlash('error','Товар не найдена');
            return $this->redirectToRoute("show");
        }
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
                $this->addFlash('error','Тип фйла не верный');
                return $this->redirectToRoute("show");
			}
            $results=$this->get("myshop_admin.upload_photo")->uploadPhoto($photoFile,$idProduct);
			$photo->setMiniFileName($results->getMiniNamePhoto());
            $photo->setSmallFileName($results->getSmallNamePhoto());
			$photo->setFileName($results->getNamePhoto());
			$photo->setProduct($product);
			$manager->persist($photo);
			$manager->flush();

            $this->addFlash('info','Фотография добавлина');

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
                $deleteFile->deleteFile($photo->getFileName(),$photo->getMiniFileName(),$photo->getSmallFileName());
                $filesArray=$request->files->get("myshop_defbundle_photoforproduct");
                /*
                * @var UploadedFile $photoFile
                */
                $photoFile=$filesArray["photoFile"];
                $checkingPhoto=$this->get("myshop_admin.checking_photo");
                try{
                    $checkingPhoto->check($photoFile);
                } catch(\InvalidArgumentException $ex){
                    $this->addFlash('error','Тип фйла не верный');
                    return $this->redirectToRoute("show");
                }
                $results=$this->get("myshop_admin.upload_photo")->uploadPhoto($photoFile,$idProduct);
                $photo->setMiniFileName($results->getMiniNamePhoto());
                $photo->setSmallFileName($results->getSmallNamePhoto());
                $photo->setFileName($results->getNamePhoto());
				$manager->persist($photo);
				$manager->flush();
                $this->addFlash('info','Фотография обновлена');

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
        $deleteFile->deleteFile($photo->getFileName(),$photo->getMiniFileName(),$photo->getSmallFileName());
		$manager->remove($photo);
		$manager->flush();

        $this->addFlash('info','Фотография удалина');
        $idProduct=$photo->getProduct()->getId();
		return $this->redirectToRoute("show_photo_for_product",["idProduct"=>$idProduct]);

	}


}