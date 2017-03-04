<?php


namespace MyShop\AdminBundle\Services;

use Eventviva\ImageResize;

class ResizePhoto
{
    public function resizeIconPhoto($photoDir,$namePhoto)
    {
        $img=new ImageResize($photoDir.$namePhoto);
        $img->resizeToBestFit(120,200);
        $iconName="icon_photo_".$namePhoto;
        $img->save($photoDir."icon/".$iconName);
        return $iconName;
    }

    public function resizeBigPhoto($photoDir,$namePhoto)
    {
        $img=new ImageResize($photoDir.$namePhoto);
        $img->resizeToBestFit(350,450);
        $bigName="big_photo_".$namePhoto;
        $img->save($photoDir."big/".$bigName);
        return $bigName;
    }

    public function resizeSmallPhoto($photoDir,$namePhoto)
    {
        $img=new ImageResize($photoDir.$namePhoto);
        $img->resizeToBestFit(250,350);
        $smallName="small_photo_".$namePhoto;
        $img->save($photoDir."small/".$smallName);
        return $smallName;
    }

    public function resizeMiniPhoto($photoDir,$namePhoto)
    {
        $img=new ImageResize($photoDir.$namePhoto);
        $img->resizeToBestFit(50,50);
        $smallName="mini_photo_".$namePhoto;
        $img->save($photoDir."mini/".$smallName);
        return $smallName;
    }
}