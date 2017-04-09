<?php

namespace MyShop\AdminBundle\Services;


use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;

class SqlQuery
{
    /**
     * @var EntityManagerInterface
    */
    private $manager;

    /**
     * @var PaginatorInterface
    */
    private $paginator;

    public  function __construct(EntityManagerInterface $manager, PaginatorInterface $paginator)
    {
        $this->manager=$manager;
        $this->paginator=$paginator;
    }

    public function getAllProduct($page=1 , $count=16)
    {
        $query=$this->manager->createQuery('select p, c from MyShopDefBundle:Product p JOIN p.category c ORDER BY p.price DESC ');
        $productList=$this->paginator->paginate($query,$page,$count);
        return $productList;
    }

    public function getListByCategory($id_category ,$page=1 , $count=16)
    {
        $query=$this->manager->createQuery('select p from MyShopDefBundle:Category p where p.id =:id')->setParameter('id',$id_category)->getResult();
        if ($query==null){
            throw  new \InvalidArgumentException("Категория не найдена");
        }
        $nameCategory=$query[0]->getName();
        $productList=$this->paginator->paginate($query[0]->getProductList(),$page,$count);
        return ["productList"=>$productList,'nameCategory'=>$nameCategory];
    }
}