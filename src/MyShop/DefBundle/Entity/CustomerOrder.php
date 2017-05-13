<?php

namespace MyShop\DefBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * CustomerOrder
 *
 * @ORM\Table(name="customer_order")
 * @ORM\Entity(repositoryClass="MyShop\DefBundle\Repository\CustomerOrderRepository")
 */
class CustomerOrder
{
    const STATUS_OPEN=1;
    const STATUS_CLOSED=2;
    const STATUS_REJECTED=3;
    const STATUS_PROCESSED=4;
    const STATUS_PROCESSED_BY_ADMIN=5;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dataCreated", type="datetime")
     */
    private $dataCreated;

    /**
     * @var int
     *
     * @ORM\Column(name="status", type="integer")
     */
    private $status;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="last_name", type="string", length=255, nullable=true)
     */
    private $lastName;

    /**
     * @var string
     *
     * @ORM\Column(name="telephone_number", type="string", length=255, nullable=true)
     */
    private $telephoneNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=255, nullable=true)
     */
    private $address;

    /**
     * @var float
     *
     * @ORM\Column(name="price_order", type="float",  nullable=true)
     */
    private $priceOrder;

    /**
     * @var string
     *
     * @ORM\Column(name="processed_by", type="string", length=255, nullable=true)
     */
    private $admin;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="MyShop\DefBundle\Entity\ListCustomerOrder", mappedBy="order", cascade={"all"})
     */
    private $productList;

    /**
     * @var Customer
     *
     * @ORM\ManyToOne(targetEntity="MyShop\DefBundle\Entity\Customer", inversedBy="order")
     * @ORM\JoinColumn(name="id_customer",referencedColumnName="id")
     */
    private $customer;

    public function __construct()
    {
        $this->setDataCreated(new \DateTime('now'));
        $this->setStatus(self::STATUS_OPEN);
        $this->productList=new ArrayCollection();
    }



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
     * Set dataCreated
     *
     * @param \DateTime $dataCreated
     *
     * @return CustomerOrder
     */
    public function setDataCreated($dataCreated)
    {
        $this->dataCreated = $dataCreated;

        return $this;
    }

    /**
     * Get dataCreated
     *
     * @return \DateTime
     */
    public function getDataCreated()
    {
        return $this->dataCreated;
    }

    /**
     * Set status
     *
     * @param integer $status
     *
     * @return CustomerOrder
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return integer
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Add productList
     *
     * @param \MyShop\DefBundle\Entity\ListCustomerOrder $productList
     *
     * @return CustomerOrder
     */
    public function addProductList(\MyShop\DefBundle\Entity\ListCustomerOrder $productList)
    {
        $productList->setOrder($this);
        $this->productList[] = $productList;

        return $this;
    }

    /**
     * Remove productList
     *
     * @param \MyShop\DefBundle\Entity\ListCustomerOrder $productList
     */
    public function removeProductList(\MyShop\DefBundle\Entity\ListCustomerOrder $productList)
    {
        $this->productList->removeElement($productList);
    }

    /**
     * Get productList
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProductList()
    {
        return $this->productList;
    }

    /**
     * Set customer
     *
     * @param \MyShop\DefBundle\Entity\Customer $customer
     *
     * @return CustomerOrder
     */
    public function setCustomer(\MyShop\DefBundle\Entity\Customer $customer = null)
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * Get customer
     *
     * @return \MyShop\DefBundle\Entity\Customer
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }



    /**
     * @return string
     */
    public function getTelephoneNumber()
    {
        return $this->telephoneNumber;
    }

    /**
     * @param string $telephoneNumber
     */
    public function setTelephoneNumber($telephoneNumber)
    {
        $this->telephoneNumber = $telephoneNumber;
    }

    /**
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param string $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

    public function getPriceAllProduct($productList,$new=false)
    {
        $price=0;
        /** @var ListCustomerOrder $product */
        foreach ($productList as $product)
        {
            $price+=$product->getPrice()*$product->getCount();
        }
        if ($new==true && $this->getPriceOrder()==0)
            $price=$productList->getPrice()*$productList->getCount();
        if ($new==true && $this->getPriceOrder()!=0)
            $price=$this->getPriceOrder()+$productList->getPrice()*$productList->getCount();
        return $price;
    }

    /**
     * @return string
     */
    public function getAdmin()
    {
        return $this->admin;
    }

    /**
     * @param string $admin
     */
    public function setAdmin($admin)
    {
        $this->admin = $admin;
    }

    /**
     * @return float
     */
    public function getPriceOrder()
    {
        return $this->priceOrder;
    }

    /**
     * @param float $priceOrder
     */
    public function setPriceOrder($priceOrder)
    {
        $this->priceOrder = $priceOrder;
    }



}
