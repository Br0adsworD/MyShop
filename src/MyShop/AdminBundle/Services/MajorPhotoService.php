<?php

namespace MyShop\AdminBundle\Services;


use Doctrine\ORM\EntityManager;

class MajorPhotoService
{
    private $manager;

    public function __construct(EntityManager $manager)
    {
        $this->manager=$manager;
    }

    public function setMajorPhoto($idProduct, $id_photo=null)
    {
        $photos=$this->manager->getRepository("MyShopDefBundle:PhotoForProduct")->findBy(['product'=>$idProduct]);
        foreach ($photos as $photo)
        {
            if ($photo->getId()!=$id_photo)
                $photo->setMajorPhoto(0);
        }
    }

    public function defaultMajorPhoto($idProduct)
    {
        $photos=$this->manager->getRepository("MyShopDefBundle:PhotoForProduct")->findBy(['product'=>$idProduct]);
        if ($photos==null)
            return;
        $arrayNULL=[];
        $k=0;
        foreach ($photos as $photo)
        {
            $k++;
            if ($photo->getMajorPhoto()!=null)
                break;
            else
                $arrayNULL+=[$photo->getId()=>$photo->getId()];
        }
        if (sizeof($arrayNULL)==$k){
            $photo=$this->manager->getRepository("MyShopDefBundle:PhotoForProduct")->find(array_shift($arrayNULL));
            $photo->setMajorPhoto(1);
            $this->manager->persist($photo);
            $this->manager->flush();
        }
    }
}