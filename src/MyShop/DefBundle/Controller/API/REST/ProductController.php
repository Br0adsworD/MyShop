<?php

namespace MyShop\DefBundle\Controller\API\REST;

use Doctrine\Common\Collections\ArrayCollection;
use MyShop\DefBundle\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class ProductController extends Controller
{
    public function infoProductAction($id)
    {
        /** @var Product $product*/
        $product=$this->getDoctrine()->getManager()->getRepository("MyShopDefBundle:Product")->find($id);

        $productList=[
            'id'=>$product->getId(),
            'manufacturer'=>$product->getManufacturer(),
            'model'=>$product->getModel(),
            'color'=>$product->getColor(),
            'price'=>$product->getPrice(),
            'iconProduct'=>"photos/icon/".$product->getIconFile(),
            'data'=>$product->getDataCreate()->format("H:i d.m.y"),
            'category'=>$product->getCategory()->getName()
        ];
        $response=new JsonResponse($productList);
        return $response;
    }

    public function infoProductListAction()
    {
        /** @var ArrayCollection $product*/
        $product=$this->getDoctrine()->getRepository("MyShopDefBundle:Product")->findAll();
        $productList=[];
        foreach ($product as $pro)
        {
            $productList[] = [
                    [
                        'id' => $pro->getId(),
                        'manufacturer' => $pro->getManufacturer(),
                        'model' => $pro->getModel(),
                        'color' => $pro->getColor(),
                        'price' => $pro->getPrice(),
                        'iconProduct' =>"photos/icon/". $pro->getIconFile(),
                        'data' => $pro->getDataCreate()->format("H:i d.m.y"),
                        'category' => $pro->getCategory()->getName()
                    ]
            ];
        }
        $response=new JsonResponse($productList);
        return $response;
    }

}