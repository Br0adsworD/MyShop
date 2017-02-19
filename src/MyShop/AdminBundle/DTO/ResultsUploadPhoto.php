<?php

namespace MyShop\AdminBundle\DTO;

class ResultsUploadPhoto
{
    private $namePhoto;

    private $smallNamePhoto;

    private $miniNamePhoto;

    public function __construct($namePhoto,$smallNamePhoto,$miniNamePhoto)
    {
        $this->namePhoto=$namePhoto;
        $this->smallNamePhoto=$smallNamePhoto;
        $this->miniNamePhoto=$miniNamePhoto;
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


}