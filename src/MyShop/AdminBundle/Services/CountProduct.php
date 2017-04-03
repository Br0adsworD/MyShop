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

    public function countProduct($nameTable)
    {
        $dql = 'select count(p) from MyShopDefBundle:'.$nameTable.' p';
        $count = $this->manager->createQuery($dql)->getSingleResult();

        return $count;
    }

}