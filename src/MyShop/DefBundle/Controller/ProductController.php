<?php
/**
 * Created by PhpStorm.
 * User: Konstantin
 * Date: 21.04.2017
 * Time: 20:12
 */

namespace MyShop\DefBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use MyShop\DefBundle\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ProductController extends Controller
{
    /**
     *@Template()
     */
    public function productInfoAction(Product $product)
    {
        if ($product==null)
        {
            $this->addFlash('error','Товар не найден');
            return $this->redirectToRoute("show");
        }
        $this->get('major_photo_service')->defaultMajorPhoto($product->getId());
        return ['product'=>$product];
    }

    public function listByCategoryAction($id_category,$page=1,$quantityProduct)
    {
        try{
            $productList=$this->get("sql_quary")->getListByCategory($id_category,$page,$quantityProduct);
        } catch (\InvalidArgumentException $ex){
            $this->addFlash('error',$ex->getMessage());
            return $this->redirectToRoute('show');
        }
        $count=$this->get('count_product')->countProduct("Product",$id_category);
        if ($count[1]==0)
        {
            $mes='Продуктов нет';
        }
        else{
            $mes='Всего продуктов категории "'.$productList['nameCategory'].'" - '.$count[1];
        }

        return $this->render("MyShopDefBundle:Default:showAll.html.twig",
            ["productList"=>$productList['productList'],
                'nameCategory'=>$productList['nameCategory'],
                'count'=>$mes,
                "idCategory"=>$id_category,
                'page'=>$page]);
    }
}