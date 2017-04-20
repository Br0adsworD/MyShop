<?php

namespace MyShop\DefBundle\Controller;

use MyShop\DefBundle\Entity\CustomerOrder;
use MyShop\DefBundle\Entity\ListCustomerOrder;
use MyShop\DefBundle\Form\CustomerOrderType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class BasketController extends Controller
{
    /**
     * @Template()
     */
    public function showOrderAction()
    {
        $manager=$this->getDoctrine()->getManager();
        $order=$manager->getRepository('MyShopDefBundle:CustomerOrder')->getOrder($this->getUser());
        return ['order'=>$order];
    }

    public function addToBasketAjaxAction($idProduct)
    {
        $this->addToBasketAction($idProduct);
        return $this->json(['message'=>'product added']);
    }

    public function addToBasketAction($idProduct)
    {
        $order=$this->showOrderAction()['order'];
        $manager=$this->getDoctrine()->getManager();
        $dql="select o from MyShopDefBundle:ListCustomerOrder o where o.order=:orderCust and o.idProduct=:idProduct";
        $productOrder=$manager->createQuery($dql)->setParameters(['orderCust'=>$order,'idProduct'=>$idProduct])->getOneOrNullResult();
        if ($productOrder!=null)
        {
            $count=$productOrder->getCount();
            $productOrder->setCount($count+1);
            $manager->persist($productOrder);
            $manager->flush();
            return $this->redirectToRoute('showAll');
        }
        else
        {
            $this->get('create_product_order')->createOrder($idProduct,$order);
            return $this->redirectToRoute('showAll');
        }
    }

    /**
     * @Template()
     */
    public function confirmOrderAction(\Symfony\Component\HttpFoundation\Request $request)
    {
        $manager=$this->getDoctrine()->getManager();
        $order=$this->showOrderAction()['order'];
        $form=$this->createForm(CustomerOrderType::class,$order);
        if ($request->isMethod('POST'))
        {
            $form->handleRequest($request);
            $order->setStatus(CustomerOrder::STATUS_CLOSED);
            $manager->persist($order);
            $manager->flush();
            return $this->redirectToRoute('showAll');
        }
        return ['form'=>$form->createView(),'order'=>$order];
    }

    /**
     * @Template()
     */
    public function historyOrdersAction()
    {
        $manager=$this->getDoctrine()->getManager();
        $orders=$manager->getRepository('MyShopDefBundle:CustomerOrder')->getOrders($this->getUser());
        return['orders'=>$orders];

    }
}