<?php

namespace MyShop\DefBundle\Controller\API\JsonRPC;

use Doctrine\Common\Collections\ArrayCollection;
use MyShop\DefBundle\Entity\PhotoForProduct;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use MyShop\DefBundle\Entity\Product;

class JsonRPCController extends Controller
{
    public function JsonRPCAction(Request $request)
    {
        $requestJson=$request->getContent();
        $requestArray=json_decode($requestJson, true);
        if($requestArray===null) {
            return new JsonResponse(['jsonrpc'=>'2.0',
                                     'error'=>['code'=>'-32700','message'=>'Parse error'],
                                     'id'=>null]);
        }
        if (isset($requestArray['method'])) {
            $method=$requestArray['method'];
            $paramsArray=$this->$method($requestArray['params']);
            if (isset($paramsArray['code'])) {
                $responseArray=[
                    'jsonrpc'=>'2.0',
                    'error'=>$paramsArray,
                    'id'=>$requestArray['id']
                ];
            }
            else {
                $responseArray=[
                    'jsonrpc'=>'2.0',
                    'result'=>$paramsArray,
                    'id'=>$requestArray['id']
                ];
            }
            return new JsonResponse($responseArray);
        }
        elseif (isset($requestArray[0]['method'])) {
            $result=[];
            foreach ($requestArray as $reqAr)
            {
                $method=$reqAr['method'];
                $paramsArray=$this->$method($reqAr['params']);
                if (isset($paramsArray['code'])) {
                    $responseArray=[
                        'jsonrpc'=>'2.0',
                        'error'=>$paramsArray,
                        'id'=>$reqAr['id']
                    ];
                }
                else {
                    $responseArray=[
                        'jsonrpc'=>'2.0',
                        'result'=>$paramsArray,
                        'id'=>$reqAr['id']
                    ];
                }
                $result[]=$responseArray;
            }
            return new JsonResponse($result);
        }
    }

    public function infoProduct($params)
    {
        /** @var Product $product*/
        $productId=$params['productId'];
        $product=$this->getDoctrine()->getManager()->getRepository("MyShopDefBundle:Product")->find($productId);
        if ($product==null) {
            return ['code'=>'-32602','message'=>'Invalid params'];
        }
        return [
            'id'=>$product->getId(),
            'manufacturer'=>$product->getManufacturer(),
            'model'=>$product->getModel(),
            'color'=>$product->getColor(),
            'price'=>$product->getPrice(),
            'iconProduct'=>"photos/icon/".$product->getIconFile(),
            'data'=>$product->getDataCreate()->format("H:i d.m.y"),
            'category'=>$product->getCategory()->getName()
        ];
    }

    public function infoProductList()
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
        return $productList;
    }


    public function category()
    {
        /** @var ArrayCollection $category*/
        $category=$this->getDoctrine()->getRepository("MyShopDefBundle:Category")->findAll();
        $categoryAr=[];
        foreach ($category as $cat) {
            if ($cat->getParentCategory() != null) {
                $idCategory = $cat->getParentCategory()->getId();
                $parentCategory = $this->getDoctrine()->getRepository("MyShopDefBundle:Category")->find($idCategory);
                $name = $parentCategory->getName();
                $categoryAr[] = [
                    'id' => $cat->getId(),
                    'name' => $cat->getName(),
                    'parent' => $name,
                    'pr'=>$cat->getProductList()
                ];
            } else {
                $categoryAr[] = [
                    'id' => $cat->getId(),
                    'name' => $cat->getName()
                ];
            }
        }
        return $categoryAr;
    }

    public function listByCategory($idCategory)
    {
        $id=$idCategory['idCategory'];
        $category=$this->getDoctrine()->getRepository("MyShopDefBundle:Category")->find($id);
        if ($category==null)
        {
            return ['code'=>'-32602','message'=>'Invalid params'];
        }
        /** @var ArrayCollection $productList*/
        $productList=$category->getProductList();
        $productAr=[];
        foreach ($productList as $product)
        {
            $productAr[]=[
                'id' => $product->getId(),
                'manufacturer' => $product->getManufacturer(),
                'model' => $product->getModel(),
                'color' => $product->getColor(),
                'price' => $product->getPrice(),
                'iconProduct' =>"photos/icon/". $product->getIconFile(),
                'data' => $product->getDataCreate()->format("H:i d.m.y"),
            ];
        }
        if ($productAr==null)
        {
            $productAr[]=[
                'message'=>'not found product'
            ];
        }
        return $productAr;
    }

    public function addProduct($data)
    {
        $pr=$this->get('product_mapper')->addProduct($data);
//        $this->getDoctrine()->getManager()->persist($pr);
//        $this->getDoctrine()->getManager()->flush();
        return ['info'=>'added product'];
    }
}