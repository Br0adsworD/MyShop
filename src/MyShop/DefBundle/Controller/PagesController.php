<?php
/**
 * Created by PhpStorm.
 * User: Konstantin
 * Date: 25.03.2017
 * Time: 19:37
 */

namespace MyShop\DefBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;


class PagesController extends Controller
{
    /**
     * @Template()
    */
    public function indexAction($pageURL)
    {
        $page=$this->getDoctrine()->getRepository('MyShopDefBundle:Pages')->findOneBy(['pageURL'=>$pageURL]);
        if ($page==null)
        {
            throw new Exception('Страница не найденна ');
        }
        return ['page'=>$page];
    }

}