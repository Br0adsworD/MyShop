<?php

namespace MyShop\DefBundle\Controller;

use GuzzleHttp\Client;
use MyShop\DefBundle\Entity\Product;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{

	// /**
	// *@Template()
	// */
 //    public function indexAction()
 //    {
 //        return [];
 //    }


    /**
	*@Template()
	*/
    public function contAction(/*Request $request,*/$idtel)
    {
    	$manager=$this->getDoctrine()->getManager();
        $repository=$manager->getRepository("MyShopDefBundle:Product");
        $product=$repository->find($idtel);
        return ["product"=>$product];
    }

    /**
    *@Template()
    */

    public function showAllAction()
    {
        $manager=$this->getDoctrine()->getManager();
        $repository=$manager->getRepository("MyShopDefBundle:Product");
        $productList=$repository->findAll();
        return ["productList"=>$productList];
    }

    /**
    *@Template()
    */
    public function createProductAction()
    {
        $product=new Product();
        $product->setManufacturer("Samsung");
        $product->setModel("NOTE");
        $product->setColor("black");
        $product->setPrice(345);

        $manager=$this->getDoctrine()->getManager();

        $manager->persist($product);
        $manager->flush();

        $response=new Response();
        $response->setContent($product->getId());
        return $response;
    }

    public function clientGuzzleAction()
    {
        $client=new Client();
        $response=$client->request("POST","http://127.0.0.1:8000/api/json");
        var_dump($response);
    }
}
