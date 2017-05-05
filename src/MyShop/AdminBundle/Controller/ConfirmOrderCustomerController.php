<?php
/**
 * Created by PhpStorm.
 * User: Konstantin
 * Date: 21.04.2017
 * Time: 18:47
 */

namespace MyShop\AdminBundle\Controller;

use MyShop\DefBundle\Entity\CustomerOrder;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ConfirmOrderCustomerController extends Controller
{
    /**
     *@Template()
     */
    public function showOrdersAction(Request $request,$page=1)
    {
        $orders=$this->get('sql_quary')->getEverythingOrders($request,$page);
        $price=$this->get('count_product')->priceAllOrders();
        return ['orders'=>$orders,'priceOrders'=>$price];
    }
    /**
     *@Template()
     */
    public function orderInfoAction(CustomerOrder $order)
    {
        return ['order'=>$order];
    }

    /**
     *@Template()
     */
    public function confirmOrderAction(CustomerOrder $customerOrder)
    {
        $manager=$this->getDoctrine()->getManager();
        $customerOrder->setStatus(CustomerOrder::STATUS_PROCESSED_BY_ADMIN);
        $customerOrder->setAdmin($this->getUser());
        $manager->persist($customerOrder);
        $manager->flush();
        return $this->redirectToRoute('show_all_orders_customer');
    }

    /**
     *@Template()
     */
    public function rejectOrderAction(CustomerOrder $customerOrder)
    {
        $manager=$this->getDoctrine()->getManager();
        $customerOrder->setStatus(CustomerOrder::STATUS_REJECTED);
        $customerOrder->setAdmin($this->getUser());
        $manager->persist($customerOrder);
        $manager->flush();
        return $this->redirectToRoute('show_all_orders_customer');
    }


}