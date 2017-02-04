<?php

namespace MyShop\DefBundle\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use MyShop\DefBundle\Entity\Product;

use Doctrine\ORM\Mapping as ORM;

/**
 * Category
 *
 * @ORM\Table(name="category")
 * @ORM\Entity(repositoryClass="MyShop\DefBundle\Repository\CategoryRepository")
 */
class Category
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
    * @var ArrayCollection
    *@ORM\OneToMany(targetEntity="MyShop\DefBundle\Entity\Product",mappedBy="category")
    */
    private $productList;

    public function __construct()
    {
        $this->productList=new ArrayCollection();
    }


    public function addProduct(Product $product)
    {
        $product->setCategory($this);
        $this->productList->add[$product];
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
     * Set name
     *
     * @param string $name
     *
     * @return Category
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Add productList
     *
     * @param \MyShop\DefBundle\Entity\Product $productList
     *
     * @return Category
     */
    public function addProductList(\MyShop\DefBundle\Entity\Product $productList)
    {
        $this->productList[] = $productList;

        return $this;
    }

    /**
     * Remove productList
     *
     * @param \MyShop\DefBundle\Entity\Product $productList
     */
    public function removeProductList(\MyShop\DefBundle\Entity\Product $productList)
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
}
