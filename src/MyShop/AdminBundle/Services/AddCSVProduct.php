<?php

namespace MyShop\AdminBundle\Services;

use MyShop\DefBundle\Entity\Product;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Config\Definition\Exception\Exception;

class AddCSVProduct
{
    /**
     * @var EntityManager
     */
    private $manager;

    /**
     * @var CheckingPhoto
     */
    private $check;

    private $photoDir;

    public function __construct(EntityManagerInterface $manager,CheckingPhoto $check, $photoDir)
    {
        $this->manager=$manager;
        $this->check=$check;
        $this->photoDir=$photoDir;
    }

    public function addData($array, $count)
    {
        if($count-- >=0)
            {
                if($array[$count]==null)
                {
                    $number=$count+1;
                    throw new Exception('пустая ячейка '.$number);
                }
                if ($count>0)
                {
                    $this->addData($array,$count);
                }
                if ($count==0) {
                    $product = new Product();
                    $product->setManufacturer($array[0]);
                    $product->setModel($array[1]);
                    $product->setColor($array[3]);
                    $product->setPrice($array[2]);
                    $category = $this->manager->getRepository("MyShopDefBundle:Category")->findBy(['name' => $array[4]]);
                    if ($category==null){
                        throw new Exception('не найдена категория');
                    }
                    $product->setCategory($category[0]);
                    $this->check->checkExtension($array[5],true);
                    $namePhoto = rand(10000, 90000000) . ".jpg";
                    copy($array[5],$this->photoDir.$namePhoto);
                    $this->check->checkFile($this->photoDir.$namePhoto);
                    $iconNameFile = new ResizePhoto();
                    $iconNamePhoto = $iconNameFile->resizeIconPhoto($this->photoDir, $namePhoto);
                    $product->setIconFile($iconNamePhoto);
                    $this->manager->persist($product);
                    $this->manager->flush();
                }
            }
        }
}