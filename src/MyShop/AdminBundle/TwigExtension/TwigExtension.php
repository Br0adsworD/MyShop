<?php

namespace MyShop\AdminBundle\TwigExtension;

use Doctrine\ORM\EntityManager;
use MyShop\DefBundle\Entity\CustomerOrder;

class TwigExtension extends \Twig_Extension
{
    private $manager;

    public function __construct(EntityManager $manager)
    {
        $this->manager=$manager;
    }

    public function getFilters()
    {
        return [new \Twig_SimpleFilter('price',[$this,'priceFormat'],['is_safe'=>["html"]]),
                new \Twig_SimpleFilter('formatPrice',[$this,'formatPrice']),
                new \Twig_SimpleFilter('category',[$this,'categoryFormat'],['is_safe'=>["html"]]),
                new \Twig_SimpleFilter('sum',[$this,'sumProductFormat']),
                new \Twig_SimpleFilter('link',[$this,'linkToProductInfo']),
                new \Twig_SimpleFilter("priceAllOrders",[$this,'priceAllOrders']),
                new \Twig_SimpleFilter('fioFormat',[$this,'formatFio']),
                new \Twig_SimpleFilter('statusOrder',[$this,'orderStatus'])];
    }


    public function priceFormat($price, $oldPrice=null)
    {
        $priceFormat=number_format($price,2,".","");
        if ($oldPrice!=null)
        {
            $oldPriceFormat=number_format($oldPrice,2,'.','');
            $html='<div class="price-block"><p class="old-price">' . $oldPriceFormat . '</p><p class="price">' . $priceFormat . '</p></div>';
        }
        else{
            $html="<div class='price-block'><p class='price'>" . $priceFormat . "</p></div>";
        }
        return $html;

    }

    public function formatPrice($price)
    {
        $priceFormat=number_format($price,2,".","");
        return $priceFormat;
    }

    public function sumProductFormat($price, $count)
    {
        $sum=$price*$count;
        $sum=$this->formatPrice($sum);
        return $sum;
    }

    public function categoryFormat($nameCategory)
    {
        $category=explode(' ',$nameCategory);
        if (count($category)>1)
        {
            $mes='';
            for($i=0;$i<count($category)-1;$i++)
                $mes.= $category[$i].' ';
            return '<h1>'.$mes.'<span>'.end($category).'</span></h1>';
        }
        else{
            return '<h1><span>'.$nameCategory.'</span></h1>';
        }

    }

    public function orderStatus($status)
    {
        if ($status==CustomerOrder::STATUS_CLOSED)
            return 'Закрыт';
        elseif ($status==CustomerOrder::STATUS_REJECTED)
            return 'Отклонен';
        elseif ($status==CustomerOrder::STATUS_PROCESSED)
            return 'Обрабатывается';
        elseif ($status==CustomerOrder::STATUS_PROCESSED_BY_ADMIN)
            return 'Обработан';
        else
            return 'Открыт';
    }

    public function linkToProductInfo($id)
    {
        $product=$this->manager->getRepository('MyShopDefBundle:Product')->find($id);
        if ($product==null)
            return false;
        else
            return true;
    }

    public function priceAllOrders($orders)
    {
        $price=0;
        foreach ($orders as $order)
        {
            $price+=$order->getPriceOrder();
        }
        return $price;
    }

    public function formatFio($fio)
    {
        $name = explode(' ',$fio);
        $res=$name[0];
        for($i=1;count($name)>$i;$i++) {
            $first = mb_substr($name[$i], 0, 1, 'UTF-8');
            $first = mb_strtoupper($first, 'UTF-8');
            $res .=' '. $first.'.';
        }
        return $res;
    }

    public function getName()
    {
        return "my_twig_extension";
    }
}