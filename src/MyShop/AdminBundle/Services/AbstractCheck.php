<?php

namespace MyShop\AdminBundle\Services;

abstract class AbstractCheck
{
    protected $photoType;

    protected $typeCSV;

    public function __construct($photoType, $typeCSV)
    {
        $this->photoType=$photoType;
        $this->typeCSV=$typeCSV;
    }

    public function checkMimeType($photoFile)
    {
        $checkTrue=false;
        $infoFile=pathinfo($photoFile);
        $mimeType=mime_content_type($infoFile['dirname'].'/'.$infoFile['basename']);
        foreach($this->photoType as $typePhoto)
        {
            if($mimeType ==$typePhoto[1])
                $checkTrue=true;
        }
        if($checkTrue!==true)
            throw new \InvalidArgumentException("Тип фото не верный");
    }

//    public function checkExtension($filePath)
//    {
//        $fileInfo = pathinfo($filePath);
//        $fileExt = $fileInfo["extension"];
//        $checkTrue = false;
//        foreach ($this->photoType as $imgType) {
//            if ($fileExt == $imgType[0]) {
//                $checkTrue = true;
//            }
//        }
//        if ($checkTrue == false) {
//            throw new \InvalidArgumentException("Не правильное расширение");
//        }
//    }

    public function checkExtension($path, $true=false)
    {
        $checkTrue=false;
        if ($true==true) {
            $link = explode(".", $path);
            $fileExt = end($link);
        }
        else{
            $fileInfo = pathinfo($path);
            $fileExt = $fileInfo["extension"];
        }
        foreach ($this->photoType as $typePhoto)
        {
            if($fileExt == $typePhoto[0])
            {
                $checkTrue=true;
            }
        }
        if($checkTrue!==true)
            throw new \InvalidArgumentException("Не правильное расширение");
        else
            return true;
    }

//    public function checkCSV($path)
//    {
//        $checkTrue=false;
//        $fileInfo = pathinfo($path);
//        $fileExt = $fileInfo["extension"];
//        $mimeType=mime_content_type($fileInfo['dirname'].'/'.$fileInfo['basename']);
//        var_dump($mimeType);
//        foreach($this->typeCSV as $csv)
//        {
//            if($mimeType ==$csv[1])
////                $checkTrue=true;
//                var_dump($csv[1]);
//        }
////        if($checkTrue!==true)
////            throw new \InvalidArgumentException("Тип фото не верный");
//        $checkTrue=false;
//        var_dump($fileExt);
//        foreach ($this->typeCSV as $csv)
//        {
//            if($fileExt == $csv[0])
//            {
//                $checkTrue=true;
//                var_dump($csv[0]);
//            }
//        }
////        if($checkTrue!==true)
////            throw new \InvalidArgumentException("Не правильное расширение");
//        die();
//    }

}