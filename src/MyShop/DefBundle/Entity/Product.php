<?php

namespace MyShop\DefBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;

use Doctrine\ORM\Mapping as ORM;

/**
 * Product
 *
 * @ORM\Table(name="product")
 * @ORM\Entity(repositoryClass="MyShop\DefBundle\Repository\ProductRepository")
 */
class Product
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="Manufacturer", type="string", length=255)
     */
    private $manufacturer;

    /**
     * @var string
     *
     * @ORM\Column(name="Model", type="string", length=255)
     */
    private $Model;

    /**
     * @var string
     *
     * @ORM\Column(name="Color", type="string", length=255)
     */
    private $color;

    /**
     * @var float
     *
     * @ORM\Column(name="Price", type="float")
     */
    private $price;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dataCreate", type="datetime")
     */
    private $dataCreate;

    /**
    * @var Category
    *@ORM\ManyToOne(targetEntity="MyShop\DefBundle\Entity\Category",inversedBy="productList")
    *@ORM\JoinColumn(name="id_category",referencedColumnName="id")
    */
    private $category;

    /**
    * @var ArrayCollection
    *@ORM\OneToMany(targetEntity="MyShop\DefBundle\Entity\PhotoForProduct",mappedBy="product")
    *
    */
    private $photo;


    public function __construct()
    {
        $date=new \DateTime("now");
        $this->setDataCreate($date);
        $photo=new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set manufacturer
     *
     * @param string $manufacturer
     *
     * @return Product
     */
    public function setManufacturer($manufacturer)
    {
        $this->manufacturer = $manufacturer;

        return $this;
    }

    /**
     * Get manufacturer
     *
     * @return string
     */
    public function getManufacturer()
    {
        return $this->manufacturer;
    }

    /**
     * Set Model
     *
     * @param string $Model
     *
     * @return Product
     */
    public function setModel($Model)
    {
        $this->Model = $Model;

        return $this;
    }

    /**
     * Get Model
     *
     * @return string
     */
    public function getModel()
    {
        return $this->Model;
    }
    
    /**
     * Set color
     *
     * @param string $color
     *
     * @return Product
     */
    public function setColor($color)
    {
        $this->color = $color;

        return $this;
    }

    /**
     * Get color
     *
     * @return string
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * Set price
     *
     * @param float $price
     *
     * @return Product
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set dataCreate
     *
     * @param \DateTime $dataCreate
     *
     * @return Product
     */
    public function setDataCreate($dataCreate)
    {
        $this->dataCreate = $dataCreate;

        return $this;
    }

    /**
     * Get dataCreate
     *
     * @return \DateTime
     */
    public function getDataCreate()
    {
        return $this->dataCreate;
    }

    /**
     * Set category
     *
     * @param \MyShop\DefBundle\Entity\Category $category
     *
     * @return Product
     */
    public function setCategory(\MyShop\DefBundle\Entity\Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \MyShop\DefBundle\Entity\Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Add photo
     *
     * @param \MyShop\DefBundle\Entity\PhotoForProduct $photo
     *
     * @return Product
     */
    public function addPhoto(\MyShop\DefBundle\Entity\PhotoForProduct $photo)
    {
        $this->photo[] = $photo;

        return $this;
    }

    /**
     * Remove photo
     *
     * @param \MyShop\DefBundle\Entity\PhotoForProduct $photo
     */
    public function removePhoto(\MyShop\DefBundle\Entity\PhotoForProduct $photo)
    {
        $this->photo->removeElement($photo);
    }

    /**
     * Get photo
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPhoto()
    {
        return $this->photo;
    }
}
