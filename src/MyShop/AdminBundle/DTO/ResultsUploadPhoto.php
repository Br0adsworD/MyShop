<?php

namespace MyShop\AdminBundle\DTO;

class ResultsUploadPhoto
{
    private $namePhoto;

    private $smallNamePhoto;

    private $miniNamePhoto;

    private $bigNamePhoto;

    public function __construct($namePhoto,$bigNamePhoto, $smallNamePhoto,$miniNamePhoto)
    {
        $this->namePhoto=$namePhoto;
        $this->smallNamePhoto=$smallNamePhoto;
        $this->miniNamePhoto=$miniNamePhoto;
        $this->bigNamePhoto=$bigNamePhoto;
    }

    /**
     * @return string
     */
    public function getNamePhoto()
    {
        return $this->namePhoto;
    }

    /**
     * @return string
     */
    public function getSmallNamePhoto()
    {
        return $this->smallNamePhoto;
    }

    /**
     * @return string
     */
    public function getMiniNamePhoto()
    {
        return $this->miniNamePhoto;
    }

    /**
     * @return mixed
     */
    public function getBigNamePhoto()
    {
        return $this->bigNamePhoto;
    }



}