<?php

namespace MyShop\AdminBundle\Services;

use MyShop\AdminBundle\DTO\ResultsUploadPhoto;
use MyShop\DefBundle\Entity\Product;
use Symfony\Component\Config\Definition\Exception\Exception;
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

    public function __construct(CheckingPhoto $check, GeneratorNameForPhoto $generator)
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
        $namePhoto= $productId . $generatorName->generateName() . $productId . "." . $uploadedFile->getClientOriginalExtension();
        $photoDir=$this->photoDir;
        $uploadedFile->move($photoDir , $namePhoto);
        $bigPhotoFile=new ResizePhoto();
        $bigNamePhoto=$bigPhotoFile->resizeBigPhoto($photoDir,$namePhoto);
        $smallPhotoFile=new ResizePhoto();
        $smallNamePhoto=$smallPhotoFile->resizeSmallPhoto($photoDir,$namePhoto);
        $miniPhotoFile=new ResizePhoto();
        $miniNamePhoto=$miniPhotoFile->resizeMiniPhoto($photoDir,$namePhoto);
        $results=new ResultsUploadPhoto($namePhoto,$bigNamePhoto,$smallNamePhoto,$miniNamePhoto);
        return $results;

    }

    public function uploadIcon(UploadedFile $uploadedFile)
    {
        $generatorName=$this->generator;
        $namePhoto=$generatorName->generateName() . "." . $uploadedFile->getClientOriginalExtension();
        $photoDir=$this->photoDir;
        $uploadedFile->move($photoDir , $namePhoto);
        $iconPhotoFile=new ResizePhoto();
        $iconNamePhoto=$iconPhotoFile->resizeIconPhoto($photoDir,$namePhoto);
        return $iconNamePhoto;
    }

    public function copyIconPhoto($iconPhoto)
    {
        copy($this->photoDir.'/icon/'.$iconPhoto,$this->photoDir.'/icon_photo_for_order/'.$iconPhoto);
    }

    public function uploadNewPhoto($request, $photo , $idProduct)
    {
        $filesArray=$request->files->get("myshop_defbundle_photoforproduct");
        $photoFile=$filesArray["photoFile"];
        $checkingPhoto=$this->check;
        try{
            $checkingPhoto->check($photoFile);
        } catch(\InvalidArgumentException $ex){
            throw new \InvalidArgumentException('Тип файле не верный');
        }
        $results=$this->uploadPhoto($photoFile,$idProduct);
        $photo->setMiniFileName($results->getMiniNamePhoto());
        $photo->setSmallFileName($results->getSmallNamePhoto());
        $photo->setBigFileName($results->getBigNamePhoto());
        $photo->setFileName($results->getNamePhoto());
    }
}