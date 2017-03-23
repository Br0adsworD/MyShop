<?php

namespace MyShop\AdminBundle\Services;


use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use MyShop\DefBundle\Entity\Category;
use MyShop\DefBundle\Entity\Product;
use Symfony\Component\Config\Definition\Exception\Exception;

class ImportExportProduct
{
    /**
     * @var EntityManager
    */
    private $manager;

    private $addData;

    public function __construct(EntityManagerInterface $manager, $addData)
    {
        $this->manager=$manager;
        $this->addData=$addData;
    }

    public function parseCSV($filePath,$clear=false)
    {
        $file=fopen($filePath,'r');
        if ($file==null)
        {
            throw new Exception("File not found");
        }
        if ($clear==true)
        {
            $this->manager->getConnection()->exec("SET foreign_key_checks=0");
            $this->manager->getConnection()->exec("truncate product");
        }
        fgetcsv($file);
        while (($data=fgetcsv($file))!=false)
        {
            $this->addData->addData($data,6);
        }
        fclose($file);
    }

    public function exportCSV()
    {
        $products=$this->manager->getRepository("MyShopDefBundle:Product")->findAll();
        $csv="производитель,модель,цена,цвет,категория,иконка товара\n";
        /** @var Product $product*/
        foreach ($products as $product)
        {
            $category=$this->manager->getRepository('MyShopDefBundle:Category')->find($product->getCategory());
            $csv.=$product->getManufacturer().','.$product->getModel().','.$product->getPrice().','.$product->getColor().','.$category->getName().','.$product->getIconFile()."\n";
        }
        return $csv;
    }
}