<?php

namespace MyShop\AdminBundle\Mapper;

use Doctrine\ORM\EntityManager;
use MyShop\DefBundle\Entity\Product;
use MyShop\AdminBundle\Services\ResizePhoto;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Config\Definition\Exception\Exception;

class ProductMapper
{
    /**
     * @var ValidatorInterface
    */
    private $validator;

    /**
     * @var EntityManager
    */
    private $manager;

    private $photoDir;

    public function __construct(ValidatorInterface $validator,EntityManager $manager , $photoDir)
    {
        $this->validator=$validator;
        $this->manager=$manager;
        $this->photoDir=$photoDir;
    }

    /**
     * @return Product
    */
    public function addProduct(array $array)
    {
        $product=new \MyShop\DefBundle\Entity\Product();
        $product->setManufacturer($array['manufacturer']);
        $product->setModel($array['model']);
        $product->setColor($array['color']);
        $product->setPrice($array['price']);
        $category = $this->manager->getRepository("MyShopDefBundle:Category")->findBy(['name' => $array['category']]);
        if ($category==null){
            throw new Exception('не найдена категория');
        }
        $product->setCategory($category[0]);//сделать проверку фоток
        $namePhoto = rand(10000, 90000000) . ".jpg";
        copy($array['linkPhoto'],$this->photoDir.$namePhoto);
        $iconNameFile = new ResizePhoto();
        $iconNamePhoto = $iconNameFile->resizeIconPhoto($this->photoDir, $namePhoto);
        $product->setIconFile($iconNamePhoto);
        $this->validator->validate($product);
//        $this->manager->persist($product);
//        $this->manager->flush();

        return $product;
    }
}