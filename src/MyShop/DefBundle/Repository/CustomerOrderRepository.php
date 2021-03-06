<?php

namespace MyShop\DefBundle\Repository;
use MyShop\DefBundle\Entity\Customer;
use MyShop\DefBundle\Entity\CustomerOrder;

class CustomerOrderRepository extends \Doctrine\ORM\EntityRepository
{
    public function getOrder(Customer $customer)
    {
        $manager=$this->getEntityManager();
        $dql="select o from MyShopDefBundle:CustomerOrder o where o.customer=:customer and o.status=:status";
        $order=$manager->createQuery($dql)->setParameters(['customer'=>$customer,'status'=>CustomerOrder::STATUS_OPEN])->getOneOrNullResult();

        if ($order==null)
        {
            $order=new CustomerOrder();
            $customer->addOrder($order);
            $manager->persist($customer);
            $manager->flush();
        }
        return $order;
    }
    public function getOrders(Customer $customer)
    {
        $manager=$this->getEntityManager();
        $dql='select o from MyShopDefBundle:CustomerOrder o where o.customer=:customer and o.status!=:status';
        $order=$manager->createQuery($dql)->setParameters(['customer'=>$customer,'status'=>CustomerOrder::STATUS_OPEN])->getResult();
        return $order;
    }

}
