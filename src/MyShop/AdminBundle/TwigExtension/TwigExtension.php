<?php

namespace MyShop\AdminBundle\TwigExtension;

class TwigExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return [new \Twig_SimpleFilter('price',[$this,'priceFormat'],['is_safe'=>["html"]])];
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

    public function getName()
    {
        return "my_twig_extension";
    }
}