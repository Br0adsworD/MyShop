<?php

namespace MyShop\AdminBundle\Services;


use Doctrine\ORM\EntityManager;
use MyShop\DefBundle\Entity\ListCustomerOrder;

class CreateProductOrder
{

    private $manager;

    public function __construct(EntityManager $manager)
    {
        $this->manager=$manager;
    }

    public function createOrder($idProduct, $order)
    {
        $product=$this->manager->getRepository("MyShopDefBundle:Product")->find($idProduct);
        $productOrder=new ListCustomerOrder();
        $productOrder->setIdProduct($product->getId());
        $productOrder->setManufacturer($product->getManufacturer());
        $productOrder->setModel($product->getModel());
        $productOrder->setColor($product->getColor());
        $productOrder->setPrice($product->getPrice());
        $productOrder->setCount(1);
        $productOrder->setOrder($order);
        $this->manager->persist($productOrder);
        $this->manager->flush();
    }
}