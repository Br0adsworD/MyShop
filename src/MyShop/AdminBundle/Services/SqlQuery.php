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

    public function getEverythingOrders($request,$page=1 , $count=20)
    {
        $sourcedql=$this->manager->createQueryBuilder()->select('o')->from('MyShopDefBundle:CustomerOrder','o');
        $dql=$this->manager->createQueryBuilder();
        $dql->select('o')->from('MyShopDefBundle:CustomerOrder','o');
        if ($request->get('name_user')!= null)
        {
            if($sourcedql==$dql)
                $dql->where($dql->expr()->like('o.name',"'".$request->get('name_user')."'"));
        }
        if ($request->get('last_name')!= null)
        {
            if($sourcedql==$dql)
                $dql->where($dql->expr()->like('o.lastName',"'".$request->get('last_name')."'"));
            else
                $dql->andwhere($dql->expr()->like('o.lastName',"'".$request->get('last_name')."'"));
        }
        if ($request->get('id_user_from')!=null)
        {
            if ($sourcedql==$dql)
                $dql->where('o.id>='.$request->get('id_user_from'));
            else
                $dql->andWhere('o.id>='.$request->get('id_user_from'));
        }
        if ($request->get('id_user_to')!=null)
        {
            if ($sourcedql==$dql)
                $dql->where('o.id<='.$request->get('id_user_to'));
            else
                $dql->andwhere('o.id<='.$request->get('id_user_to'));
        }
        if ($request->get('status')!=0)
        {
            if ($sourcedql==$dql)
                $dql->where("o.status=".$request->get('status'));
            else
                $dql->andwhere("o.status=".$request->get('status'));
        }
        if ($request->get('count')!=0)
            $count=$request->get('count');
        $query=$this->manager->createQuery($dql->getdql())->getResult();
        if ($query==null)
            return null;
        $orderList=$this->paginator->paginate($query,$page,$count);
        return $orderList;
    }

    public function getResultSearch($keyWord, $page=1 , $count=16)
    {
        $dql='select p from MyShopDefBundle:Product p where p.Model like :keyWord or p.manufacturer like :keyWord';
        $query=$this->manager->createQuery($dql)->setParameter('keyWord','%'.$keyWord.'%')->getResult();
        $productList=$this->paginator->paginate($query,$page,$count);
        return $productList;
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