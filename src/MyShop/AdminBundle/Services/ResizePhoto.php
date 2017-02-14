<?php


namespace MyShop\AdminBundle\Services;

use Eventviva\ImageResize;

class ResizePhoto
{
    public function resizeSmallPhoto($photoDir,$namePhoto)
    {
        $img=new ImageResize($photoDir.$namePhoto);
        $img->resizeToBestFit(120,200);
        $smallName="small_photo_".$namePhoto;
        $img->save($photoDir.$smallName);
        return $smallName;
    }

    public function resizeMiniPhoto($photoDir,$namePhoto)
    {
        $img=new ImageResize($photoDir.$namePhoto);
        $img->resizeToBestFit(60,100);
        $smallName="mini_photo_".$namePhoto;
        $img->save($photoDir.$smallName);
        return $smallName;
    }
}