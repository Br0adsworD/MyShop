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

    private $checkCSV;

    public function __construct(EntityManagerInterface $manager, $addData, $checkCSV)
    {
        $this->manager=$manager;
        $this->addData=$addData;
        $this->checkCSV=$checkCSV;
    }

    public function parseCSV($filePath,$clear=false)
    {
        //check csv
//        $this->checkCSV->checkCSV($filePath);
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
        $message=[];
        while (($data=fgetcsv($file))!=false)
        {
            $this->addData->addData($data,6);
            $message[]='Added product '.$data[0].' '.$data[1];
        }
        fclose($file);
        return $message;
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