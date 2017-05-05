<?php

namespace MyShop\AdminBundle\Services;


use Doctrine\ORM\EntityManager;
use MyShop\DefBundle\Entity\ListCustomerOrder;

class CreateProductOrder
{

    private $manager;

    private $uploadPhoto;

    public function __construct(EntityManager $manager,$upload)
    {
        $this->manager=$manager;
        $this->uploadPhoto=$upload;
    }

    public function createOrder($idProduct, $order)
    {
        $product=$this->manager->getRepository("MyShopDefBundle:Product")->find($idProduct);
        $this->uploadPhoto->copyIconPhoto($product->getIconFile());
        $productOrder=new ListCustomerOrder();
        $productOrder->setIdProduct($product->getId());
        $productOrder->setManufacturer($product->getManufacturer());
        $productOrder->setModel($product->getModel());
        $productOrder->setColor($product->getColor());
        $productOrder->setPrice($product->getPrice());
//        echo 'getPrice-'.$productOrder->getPrice().'<br>';
        $productOrder->setCount(1);
//        echo 'getCount-'.$productOrder->getCount().'<br>';
        $productOrder->setOrder($order);
        $productOrder->setProductPhoto($product->getIconFile());
        $this->manager->persist($productOrder);
        $this->manager->flush();
        $order->setPriceOrder($order->getPriceAllProduct());
        $this->manager->persist($order);
        $this->manager->flush();

//        echo 'getPriceAll-'.$order->getPriceAllProduct().'<br>';
//        $order->setPriceOrder($order->getPriceAllProduct());
//        echo  'getPriceOrder-'.$order->getPriceOrder();
//        $this->manager->persist($order);
//        $this->manager->flush();
    }
}