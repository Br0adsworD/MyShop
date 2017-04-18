<?php

namespace MyShop\DefBundle\Repository;
use MyShop\DefBundle\Entity\Customer;
use MyShop\DefBundle\Entity\CustomerOrder;

/**
 * CustomerOrderRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CustomerOrderRepository extends \Doctrine\ORM\EntityRepository
{
    public function getOrder(Customer $customer, $noOpen=false)
    {
        $manager=$this->getEntityManager();
//        $dql="select o from MyShopDefBundle:CustomerOrder o where o.customer=:customer and o.status";
        if ($noOpen==true)
            $dql="select o from MyShopDefBundle:CustomerOrder o where o.customer=:customer and o.status!=:status";

        else
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

    public function getClosedOrder(Customer $customer)
    {
        $manager=$this->getEntityManager();
        $dql="select o from MyShopDefBundle:CustomerOrder o where o.customer=:customer and o.status!=:status";
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
}
