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
    *@ORM\OneToMany(targetEntity="MyShop\DefBundle\Entity\Product",mappedBy="category", cascade={"all"})
    */
    private $productList;

    /**
     * @var Category
     *
     * @ORM\ManyToOne(targetEntity="MyShop\DefBundle\Entity\Category", inversedBy="subCategory")
     * @ORM\JoinColumn(name="id_parent", referencedColumnName="id")
     */
    private $parentCategory;

    /**
    * @var ArrayCollection
    *
    * @ORM\OneToMany(targetEntity="MyShop\DefBundle\Entity\Category", mappedBy="parentCategory",cascade="all")
    */
    private $subCategory;

    public function __construct()
    {
        $this->productList=new ArrayCollection();
    }


    public function addProduct(Product $product)
    {
        $product->setCategory($this);
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

    /**
     * @return ArrayCollection
     */
    public function getSubCategory()
    {
        return $this->subCategory;
    }

    /**
     * @param ArrayCollection $subCategory
     * @return Category
     */
    public function addSubCategory($subCategory)
    {
        $this->subCategory[] = $subCategory;
        return $this;
    }

    /**
     * Remove subCategory
     * @param Category $subCategory
     */
    public function removeSubCategory($subCategory)
    {
        $this->subCategory=removeElement($subCategory);
    }

    /**
     * @return Category
     */
    public function getParentCategory()
    {
        return $this->parentCategory;
    }

    /**
     * @param Category $parentCategory
     * @return Category
     */
    public function setParentCategory($parentCategory = null)
    {
        $this->parentCategory = $parentCategory;
        return $this;
    }

}
