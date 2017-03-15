<?php

namespace MyShop\DefBundle\TestData;

use Doctrine\ORM\EntityManager;
use MyShop\AdminBundle\Entity\Users;
use MyShop\DefBundle\Entity\Category;
use MyShop\DefBundle\Entity\Product;
use Symfony\Component\HttpFoundation\Request;

class LoadingTestData
{
    /**
     * @var EntityManager
    */
    private $manager;

    public function __construct(EntityManager $manager)
    {
        $this->manager=$manager;
    }

    public function loadingProduct()
    {
        $product=new Product();
        $product->setManufacturer("Samsung".rand(1,99));
        $product->setModel("NOTE".rand(1,99));
        $product->setColor("black".rand(1,99));
        $product->setPrice("345".rand(1,99));
        $category=$this->manager->getRepository("MyShopDefBundle:Category")->find(1);
        $product->setCategory($category);

//        сделать загрузку фотки
        $product->setIconFile('icon_photo_488790139.jpg');
//        $results=$this->get("myshop_admin.upload_photo")->uploadIcon($photoFile);
//        $product->setIconFile($results);

        $this->manager->persist($product);
        $this->manager->flush();
    }

    public function loadingAdmin()
    {
        $admin=new Users();
        $admin->setUserName("testAdmin".rand(1000,99999999));
        $admin->setEmail(rand(1000,99999999)."@mail.ru");
        $admin->setPassword(rand(100,999999999999));
        $this->manager->persist($admin);
        $this->manager->flush();
    }
}