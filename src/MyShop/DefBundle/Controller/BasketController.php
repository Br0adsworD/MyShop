<?php

namespace MyShop\DefBundle\Controller;

use MyShop\DefBundle\Entity\CustomerOrder;
use MyShop\DefBundle\Entity\ListCustomerOrder;
use MyShop\DefBundle\Form\CustomerOrderType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

class BasketController extends Controller
{
    /**
     * @Template()
     */
    public function showOrderAction()
    {
//        function merge_sort($my_array){
//            if(count($my_array) == 1 ) return $my_array;
//            $mid = count($my_array) / 2;
//            $left = array_slice($my_array, 0, $mid);
//            $right = array_slice($my_array, $mid);
//            $left = merge_sort($left);
//            $right = merge_sort($right);
//            return merge($left, $right);
//        }
//
//        function merge($left, $right){
//            $res = array();
//            while (count($left) > 0 && count($right) > 0){
//                if($left[0] > $right[0]){
//                    $res[] = $right[0];
//                    $right = array_slice($right , 1);
//                }else{
//                    $res[] = $left[0];
//                    $left = array_slice($left, 1);
//                }
//            }
//            while (count($left) > 0){
//                $res[] = $left[0];
//                $left = array_slice($left, 1);
//            }
//            while (count($right) > 0){
//                $res[] = $right[0];
//                $right = array_slice($right, 1);
//            }
//            return $res;
//        }
//        $test_array = array(100, 54, 7, 2, 5, 4, 1);
//        echo "Original Array : ";
//        echo implode(', ',$test_array );
//        echo "\nSorted Array :";
//        echo implode(', ',merge_sort($test_array))."\n";
//        die;
        $manager=$this->getDoctrine()->getManager();
        $order=$manager->getRepository('MyShopDefBundle:CustomerOrder')->getOrder($this->getUser());
        return ['order'=>$order];
    }

    /**
     *@Template()
     */
    public function orderInfoAction(CustomerOrder $order)
    {
        return ['order'=>$order];
    }

    public function addToBasketAjaxAction($idProduct)
    {
        $this->addToBasketAction($idProduct);
        return $this->json(['message'=>'product added']);
    }

    public function addToBasketAction($idProduct)
    {
        $manager=$this->getDoctrine()->getManager();
        $order=$manager->getRepository('MyShopDefBundle:CustomerOrder')->getOrder($this->getUser());
        $dql='select p from MyShopDefBundle:ListCustomerOrder p where p.order=:customerOrder and p.idProduct=:idProduct';
        $productOrder=$manager->createQuery($dql)->setParameters(['customerOrder'=>$order,'idProduct'=>$idProduct])->getOneOrNullResult();

        if ($productOrder!==null)
        {
            $count=$productOrder->getCount();
            $productOrder->setCount(++$count);
            $order->setPriceOrder($order->getPriceAllProduct());
            $manager->persist($productOrder);
            $manager->flush();

            return $this->redirectToRoute('showAll');
        }
        else
        {
            $this->get('create_product_order')->createOrder($idProduct, $order);
//            die();
            return $this->redirectToRoute('showAll');
        }
//        $order=$this->showOrderAction()['order'];
//        $manager=$this->getDoctrine()->getManager();
//        $dql="select o from MyShopDefBundle:ListCustomerOrder o where o.order=:orderCust and o.idProduct=:idProduct";
//        $productOrder=$manager->createQuery($dql)->setParameters(['orderCust'=>$order->getId(),'idProduct'=>$idProduct])->getOneOrNullResult();
////        var_dump($productOrder);
//
//        if ($productOrder==null)
//            var_dump($productOrder);
//
//        if ($productOrder!==null)
//        {
//            echo 'if ----------------------'.'<br>';
//            $count=$productOrder->getCount();
//            echo 'count-'.$count.'<br>';
//            $productOrder->setCount($count+1);
//            echo 'getcount-'.$productOrder->getCount().'<br>';
////            $order->setPriceOrder($order->getPriceAllProduct());
//            echo 'getPriceOrder-'.$order->getPriceOrder().'<br>';
//            $manager->persist($productOrder);
//            $manager->flush();
////            $manager->persist($order);
////            $manager->flush();
//            die();
//            return $this->redirectToRoute('showAll');
//        }
//        else
//        {
//            echo 'else---------------------------'.'<br>';
//            $this->get('create_product_order')->createOrder($idProduct,$order);
////            $order->setPriceOrder($order->getPriceAllProduct());
////            $manager->persist($order);
////            $manager->flush();
//            die();
//            return $this->redirectToRoute('showAll');
//        }
    }

    /**
     * @Template()
     */
    public function confirmOrderAction(\Symfony\Component\HttpFoundation\Request $request)
    {
        $manager=$this->getDoctrine()->getManager();
        $order=$this->showOrderAction()['order'];
        if ($order->getPriceAllProduct()==null)
        {
            return $this->redirectToRoute("show_order");
        }
        $form=$this->createForm(CustomerOrderType::class,$order);
        if ($request->isMethod('POST'))
        {
            $form->handleRequest($request);
            $order->setStatus(CustomerOrder::STATUS_PROCESSED);
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

    public function deleteProductFromOrderAction(ListCustomerOrder $customerOrder)
    {
        $manager=$this->getDoctrine()->getManager();
        $order=$manager->getRepository('MyShopDefBundle:CustomerOrder')->find($customerOrder->getOrder()->getId());
        $manager->remove($customerOrder);
        $manager->flush();
        $order->setPriceOrder($order->getPriceAllProduct());
        $manager->persist($order);
        $manager->flush();
        return $this->json(['message'=>'product was deleted from basket','price'=>$order->getPriceAllProduct()]);
    }

    public function recalculationCountAction(Request $request)
    {
        $manager=$this->getDoctrine()->getManager();
        $order=$manager->getRepository('MyShopDefBundle:CustomerOrder')->getOrder($this->getUser());
        /** @var ListCustomerOrder $product */
        foreach ($order->getProductList() as $product)
        {
            $key='count_product_'.$product->getId();
            $count=$request->get($key);
            $count=intval($count);
            if($count>0)
                $product->setCount($count);
            else
                $product->setCount(1);
            $order->setPriceOrder($order->getPriceAllProduct());
        }
        $manager->persist($order);
        $manager->flush();
        return $this->redirectToRoute('show_order');
    }
}