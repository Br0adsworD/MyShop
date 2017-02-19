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

    public function deleteFile( $photoName, $photoMiniName, $photoSmallName)
    {
        $namePhoto=$this->photoDir . $photoName;
        $miniNamePhoto=$this->photoDir . $photoMiniName;
        $smallNamePhoto=$this->photoDir . $photoSmallName;
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
    }
}