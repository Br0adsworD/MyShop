<?php

namespace MyShop\DefBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ListCustomerOrder
 *
 * @ORM\Table(name="list_customer_order")
 * @ORM\Entity(repositoryClass="MyShop\DefBundle\Repository\ListCustomerOrderRepository")
 */
class ListCustomerOrder
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
     * @var int
     *
     * @ORM\Column(name="idProduct", type="integer")
     */
    private $idProduct;

    /**
     * @var string
     *
     * @ORM\Column(name="model", type="string", length=255)
     */
    private $model;

    /**
     * @var string
     *
     * @ORM\Column(name="manufacturer", type="string", length=255)
     */
    private $manufacturer;

    /**
     * @var string
     *
     * @ORM\Column(name="color", type="string", length=255)
     */
    private $color;

    /**
     * @var float
     *
     * @ORM\Column(name="price", type="float")
     */
    private $price;

    /**
     * @var int
     *
     * @ORM\Column(name="count", type="integer")
     */
    private $count;

    /**
     * @var string
     *
     * @ORM\Column(name="product_photo", type="string")
     */
    private $productPhoto;

    /**
     * @var CustomerOrder
     *
     * @ORM\ManyToOne(targetEntity="MyShop\DefBundle\Entity\CustomerOrder", inversedBy="productList")
     * @ORM\JoinColumn(name="id_order" , referencedColumnName="id")
     */
    private $order;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set idProduct
     *
     * @param integer $idProduct
     *
     * @return ListCustomerOrder
     */
    public function setIdProduct($idProduct)
    {
        $this->idProduct = $idProduct;

        return $this;
    }

    /**
     * Get idProduct
     *
     * @return integer
     */
    public function getIdProduct()
    {
        return $this->idProduct;
    }

    /**
     * Set model
     *
     * @param string $model
     *
     * @return ListCustomerOrder
     */
    public function setModel($model)
    {
        $this->model = $model;

        return $this;
    }

    /**
     * Get model
     *
     * @return string
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * Set manufacturer
     *
     * @param string $manufacturer
     *
     * @return ListCustomerOrder
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
     * Set color
     *
     * @param string $color
     *
     * @return ListCustomerOrder
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
     * @return ListCustomerOrder
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
     * Set count
     *
     * @param integer $count
     *
     * @return ListCustomerOrder
     */
    public function setCount($count)
    {
        $this->count = $count;

        return $this;
    }

    /**
     * Get count
     *
     * @return integer
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * Set order
     *
     * @param \MyShop\DefBundle\Entity\CustomerOrder $order
     *
     * @return ListCustomerOrder
     */
    public function setOrder(\MyShop\DefBundle\Entity\CustomerOrder $order = null)
    {
        $this->order = $order;

        return $this;
    }

    /**
     * Get order
     *
     * @return \MyShop\DefBundle\Entity\CustomerOrder
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * @return string
     */
    public function getProductPhoto()
    {
        return $this->productPhoto;
    }

    /**
     * @param string $productPhoto
     */
    public function setProductPhoto($productPhoto)
    {
        $this->productPhoto = $productPhoto;
    }

}
