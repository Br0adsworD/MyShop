<?php

namespace MyShop\DefBundle\TestData;

use Doctrine\ORM\EntityManager;
use MyShop\AdminBundle\Entity\Users;
use MyShop\DefBundle\Entity\Category;
use MyShop\DefBundle\Entity\Product;
use MyShop\AdminBundle\Services\ResizePhoto;
use Symfony\Component\HttpFoundation\Request;

class LoadingTestData
{
    /**
     * @var EntityManager
    */
    private $manager;

    private $testPhotoDir;

    private $photoDir;

    public function __construct(EntityManager $manager, $testPhotoDir, $photoDir)
    {
        $this->manager=$manager;
        $this->testPhotoDir=$testPhotoDir;
        $this->photoDir=$photoDir;
    }

    public function loadingProduct()
    {
        $testDir=$this->testPhotoDir;
        $files=scandir($testDir);
        $photoDir=$this->photoDir;
        foreach ($files as $file)
        {
            if ($file!='.' && $file!='..')
            {
                $filePath=$testDir . $file;
                $partName=explode(".",$file);
                $fileName=$partName[0].rand(1,1000).".".$partName[1];
                copy($filePath,$photoDir.$fileName);
                $iconPhotoFile=new ResizePhoto();
                $iconNamePhoto=$iconPhotoFile->resizeIconPhoto($photoDir,$fileName);
                $product=new Product();
                $product->setManufacturer("Samsung".rand(1,99));
                $product->setModel("NOTE".rand(1,99));
                $product->setColor("black".rand(1,99));
                $product->setPrice(rand(1,9999));
                $category=$this->manager->getRepository("MyShopDefBundle:Category")->find(1);
                $product->setCategory($category);
                $product->setIconFile($iconNamePhoto);
                $this->manager->persist($product);
                $this->manager->flush();
            }
        }
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