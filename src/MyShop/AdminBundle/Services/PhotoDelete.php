<?php

namespace MyShop\AdminBundle\Services;


use Doctrine\ORM\EntityManager;

class PhotoDelete
{
    private $manager;

    private $photoDir;

    public function __construct(EntityManager $manager, $photoDir)
    {
        $this->manager=$manager;
        $this->photoDir=$photoDir;
    }

    public function deleteIcon($icon)
    {
        $namePhoto=$this->photoDir."icon/".$icon;
        if (file_exists($namePhoto))
        {
            unlink($namePhoto);
        }
    }

    public function deleteFile( $photoName, $photoMiniName, $photoSmallName, $photoBigName)
    {
        $namePhoto=$this->photoDir . $photoName;
        $miniNamePhoto=$this->photoDir ."mini/". $photoMiniName;
        $smallNamePhoto=$this->photoDir ."small/". $photoSmallName;
        $bigNamePhoto=$this->photoDir."big/". $photoBigName;
        if (file_exists($namePhoto))
        {
            unlink($namePhoto);
        }
        if (file_exists($miniNamePhoto))
        {
            unlink($miniNamePhoto);
        }
        if (file_exists($smallNamePhoto))
        {
            unlink($smallNamePhoto);
        }
        if (file_exists($bigNamePhoto))
        {
            unlink($bigNamePhoto);
        }
    }
}