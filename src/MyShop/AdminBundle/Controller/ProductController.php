<?php

namespace MyShop\AdminBundle\Controller;

use MyShop\AdminBundle\Services\SendingLetters;
use MyShop\DefBundle\Entity\Product;
use MyShop\DefBundle\Form\ProductType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolationList;

class ProductController extends MyController
{
	/**
	*@Template()
	*/
	public function showAction($page=1)
	{


//	    die();
        $productList=$this->get("sql_quary")->getAllProduct($page);
        $count=$this->get('count_product')->countProduct("Product");//количество продуктов

        return ["productList"=>$productList,'count'=>"Всего ".$count[1]." продуктов"];
    }

    public function listByCategoryAction($id_category)
    {
    	$category=$this->get("sql_quary")->getListByCategory($id_category);
    	var_dump($category);
    	die();
        if ($category==null)
        {
            $this->addFlash('error','Такой категории не существует');
            return $this->redirectToRoute("show");
        }
    	$productList=$category->getProductList();
        $count=$this->get('count_product')->countProduct("Product");
        if ($count==0)
        {
            $mes='Продуктов нет';
        }
        else{
            $mes='Всего продуктов категории "'.$category->getName().'" - '.$count[1];
        }
        return $this->render("MyShopAdminBundle:Product:show.html.twig",
            ["productList"=>$productList,
             'nameCategory'=>$category->getName(),
            'count'=>$mes]);
    }
	
    
	public function deleteAction(Product $product)
	{
		$manager=$this->getDoctrine()->getManager();
        if ($product==null)
        {
            $this->addFlash('error','Товар не найден');
            return $this->redirectToRoute("show");
        }
        $icon=$product->getIconFile();
        $deleteFile=$this->get("myshop_admin.delete_photo");
        $deleteFile->deleteicon($icon);
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
                $icon=$product->getIconFile();
                $deleteFile=$this->get("myshop_admin.delete_photo");
                $deleteFile->deleteicon($icon);

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
                    return $this->redirectToRoute("admin_add");
                }
                $results=$this->get("myshop_admin.upload_photo")->uploadIcon($photoFile);
                $product->setIconFile($results);

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
                    $this->addFlash('error',"Произошла ошибка:".$ex->getMessage());
                    return $this->redirectToRoute("admin_add");
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

    /**
     *@Template()
     */
	public function importProductAction(Request $request)
    {
        $form=$this->createFormBuilder()->add('csv_file',FileType::class,['label'=>'Выберите файл'])
            ->add('clearEntity',CheckboxType::class,['label'=>"удалить предыдущие товары","required"=>false])->getForm();
        $form->handleRequest($request);
        if ($request->isMethod("POST") && $form->isValid())
        {
            $data=$form->getData();
            /** @var UploadedFile $file*/
            $file=$data['csv_file'];
            try{
                $message=$this->get('import-export_product')->parseCSV($file->getRealPath(),$data['clearEntity']);
            } catch (\Exception $exception){
                $this->addFlash('error',"Произошла ошибка:".$exception->getMessage());
                return $this->redirectToRoute("import_product_csv");
            }
            foreach ($message as $mes)
            {
                $this->notification($mes);
            }
            return $this->redirectToRoute("show");
        }
        return ['form'=>$form->createView()];
    }

    public function exportProductsAction()
    {
        $csv=$this->get('import-export_product')->exportCSV();
        $response=new Response($csv);
        $response->headers->set('Content-disposition','attachment;filename=myshop_'.date("h:i:s d.m.y").'.csv');
        return $response;
    }
}