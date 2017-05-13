<?php

namespace MyShop\DefBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class SearchController extends Controller
{
    /**
     *@Template()
     */
    public function searchAction(Request $request)
    {
        $keyWord=$request->get('search');
        $productList=$this->get('sql_quary')->getResultSearch($keyWord);
        return ['productList'=>$productList];
    }
}