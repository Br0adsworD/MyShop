<?php

namespace MyShop\AdminBundle\Services;

use MyShop\AdminBundle\DTO\ResultsUploadPhoto;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UploadPhotoService
{
    /**
     * @var CheckingPhoto
    */
    private $check;

    /**
     * @var GeneratorNameForPhoto
    */
    private $generator;

    private $photoDir;

    public function __construct(CheckingPhoto $check,GeneratorNameForPhoto $generator)
    {
        $this->check=$check;
        $this->generator=$generator;
    }

    public function setPhotoDir($photoDir)
    {
        $this->photoDir = $photoDir;
    }

    public function uploadPhoto(UploadedFile $uploadedFile,$productId)
    {
        $generatorName=$this->generator;
        $namePhoto=$productId . $generatorName->generateName() . $productId . "." . $uploadedFile->getClientOriginalExtension();
        $photoDir=$this->photoDir;
        $uploadedFile->move($photoDir , $namePhoto);

        $resize=new ResizePhoto();
        $smallName=$resize->resizeSmallPhoto($photoDir,$namePhoto);

        $MiniPhoto=new ResizePhoto();
        $MiniName=$MiniPhoto->resizeMiniPhoto($photoDir,$namePhoto);

        $results=new ResultsUploadPhoto($namePhoto,$smallName,$MiniName);

        return $results;

    }


}