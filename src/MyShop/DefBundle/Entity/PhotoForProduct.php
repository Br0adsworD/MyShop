<?php

namespace MyShop\DefBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;

use Doctrine\ORM\Mapping as ORM;

/**
 * PhotoForProduct
 *
 * @ORM\Table(name="photo_for_product")
 * @ORM\Entity(repositoryClass="MyShop\DefBundle\Repository\PhotoForProductRepository")
 */
class PhotoForProduct
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
     * @ORM\Column(name="name", type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="FileName", type="string", length=255, unique=true)
     */
    private $fileName;

    /**
     * @var string
     *
     * @ORM\Column(name="SmallFileName", type="string", length=255)
     */
    private  $smallFileName;

    /**
     * @var Product
     *
     * @ORM\ManyToOne(targetEntity="MyShop\DefBundle\Entity\Product",inversedBy="photo")
     * @ORM\JoinColumn(name="product_id",referencedColumnName="id")
     */
    private $product;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dataCreate", type="datetime")
     */
    private $dataCreate;

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
     * Set name
     *
     * @param string $name
     *
     * @return PhotoForProduct
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
     * Set fileName
     *
     * @param string $fileName
     *
     * @return PhotoForProduct
     */
    public function setFileName($fileName)
    {
        $this->fileName = $fileName;

        return $this;
    }

    /**
     * Get fileName
     *
     * @return string
     */
    public function getFileName()
    {
        return $this->fileName;
    }

    /**
     * @return string
     */
    public function getSmallFileName()
    {
        return $this->smallFileName;
    }

    /**
     * @param string $smallFileName
     */
    public function setSmallFileName($smallFileName)
    {
        $this->smallFileName = $smallFileName;
    }

    /**
     * Set product
     *
     * @param \MyShop\DefBundle\Entity\Product $product
     *
     * @return PhotoForProduct
     */
    public function setProduct(\MyShop\DefBundle\Entity\Product $product = null)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * Get product
     *
     * @return \MyShop\DefBundle\Entity\Product
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * Set dataCreate
     *
     * @param \DateTime $dataCreate
     *
     * @return PhotoForProduct
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
}
