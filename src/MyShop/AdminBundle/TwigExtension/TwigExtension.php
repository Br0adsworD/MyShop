<?php

namespace MyShop\AdminBundle\TwigExtension;

use MyShop\DefBundle\Entity\CustomerOrder;

class TwigExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return [new \Twig_SimpleFilter('price',[$this,'priceFormat'],['is_safe'=>["html"]]),
                new \Twig_SimpleFilter('category',[$this,'categoryFormat'],['is_safe'=>["html"]]),
                new \Twig_SimpleFilter('sum',[$this,'sumProductFormat']),
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

    public function sumProductFormat($price, $count)
    {
        $sum=$price*$count;
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
        {
            return 'открыт';
        }
        elseif ($status==CustomerOrder::STATUS_REJECTED)
        {
            return 'Отлонен';
        }
    }

    public function getName()
    {
        return "my_twig_extension";
    }
}