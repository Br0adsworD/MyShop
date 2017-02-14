<?php

namespace MyShop\AdminBundle\DTO;

class ResultsUploadPhoto
{
    private $name;

    private $smallName;

    private $miniName;

    public function __construct($name,$smallName,$miniName)
    {
        $this->name=$name;
        $this->smallName=$smallName;
        $this->miniName=$miniName;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getSmallName()
    {
        return $this->smallName;
    }

    /**
     * @return string
     */
    public function getMiniName()
    {
        return $this->miniName;
    }


}