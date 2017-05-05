<?php

namespace MyShop\AdminBundle\Services;


use Doctrine\ORM\EntityManagerInterface;

class CountProduct
{
    /**
     * @var EntityManagerInterface
    */
    private $manager;

    public function __construct(EntityManagerInterface $man)
    {
        $this->manager=$man;
    }

    public function countProduct($nameTable, $idCategory=false)
    {
        $dql = 'select count(p) from MyShopDefBundle:'.$nameTable.' p';
        if($idCategory==true)
            $dql.=' where p.category='.$idCategory;
        $count = $this->manager->createQuery($dql)->getSingleResult();
        return $count;
    }

    public function priceAllOrders()
    {
        $orders=$this->manager->getRepository('MyShopDefBundle:CustomerOrder')->findAll();
        $price=0;
        foreach ($orders as $order)
            $price+=$order->getPriceOrder();
        return$price;

    }

}