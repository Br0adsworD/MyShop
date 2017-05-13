<?php

namespace MyShop\DefBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
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
     * @Assert\NotBlank(message="Обязательно заполнить производителя")
     * @Assert\Length(
     *     min="2",minMessage="Слишком короткое название производителя",
     *     max="255",maxMessage="Слишком длинное название производителя")
     */
    private $manufacturer;

    /**
     * @var string
     *
     * @ORM\Column(name="Model", type="string", length=255)
     * @Assert\NotBlank(message="Обязательно заполнить модель")
     * @Assert\Length(
     *     min="2",minMessage="Слишкос короткое название модели",
     *     max="255",maxMessage="Слишком длинное название модели")
     */
    private $Model;

    /**
     * @var string
     *
     * @ORM\Column(name="Color", type="string", length=255)
     * @Assert\NotBlank(message="Обязательно заполнить цвет")
     * @Assert\Length(
     *     min="2",minMessage="Слишкос короткое название цвета",
     *     max="255",maxMessage="Слишком длинное название цвета")
     */
    private $color;

    /**
     * @var float
     *
     * @ORM\Column(name="Price", type="float")
     * @Assert\NotBlank(message="Обязательно заполнить цену")
    
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
     * @Assert\NotBlank(message="Обязательно заполнить категорию")
    */
    private $category;

    /**
    * @var ArrayCollection
    *@ORM\OneToMany(targetEntity="MyShop\DefBundle\Entity\PhotoForProduct",mappedBy="product",cascade="all")
    *
    */
    private $photo;

    /**
     * @var string
     *
     * @ORM\Column(name="IconFile",type="string", length=255, nullable=false)
     * @Assert\File(maxSize="15M",maxSizeMessage="Слишком большой файл")
     *
    */
    private $iconFile;

    /**
    * @var string
    *
    * @ORM\Column(name="os", type="string", length=255, nullable=true)
     *@Assert\Length(
     *     min="2",minMessage="Слишком короткое название ОС",
     *     max="255",maxMessage="Слишком длинное название ОС")
 */
    private $os;

    /**
     * @var string
     *
     * @ORM\Column(name="screen_size", type="string", length=255, nullable=true)
     * @Assert\Length(
     *     min="2",minMessage="Ошибка в поле 'Размер экаран'",
     *     max="255",maxMessage="Ошибка в поле 'Размер экаран'")
     */
    private $screen_size;

    /**
     * @var string
     *
     * @ORM\Column(name="screen_resolution", type="string", length=255, nullable=true)
     * @Assert\Length(
     *     min="2",minMessage="Ошибка в поле 'Размер экаран'",
     *     max="255",maxMessage="Ошибка в поле 'Разрешение экаран'")
     */
    private $screen_resolution;

    /**
     * @var string
     *
     * @ORM\Column(name="type_screen", type="string", length=255, nullable=true)
     * @Assert\Length(
     *     min="2",minMessage="Ошибка в поле 'Тип экаран'",
     *     max="255",maxMessage="Ошибка в поле 'Тип экаран'")
     */
    private $type_screen;

    /**
     * @var string
     *
     * @ORM\Column(name="processor", type="string", length=255, nullable=true)
     * @Assert\Length(
     *     min="2",minMessage="Ошибка в поле 'Процесор'",
     *     max="255",maxMessage="Ошибка в поле 'Процесор'")
     */
    private $processor;

    /**
     * @var string
     *
     * @ORM\Column(name="ram", type="string", length=255, nullable=true)
     * @Assert\Length(
     *     min="2",minMessage="Ошибка в поле 'RAM'",
     *     max="255",maxMessage="Ошибка в поле 'RAM")
     */
    private $ram;

    /**
     * @var string
     *
     * @ORM\Column(name="quantity_sim", type="string", length=255, nullable=true)
     * @Assert\Length(
     *     min="2",minMessage="Ошибка в поле 'Кол-во SIM'",
     *     max="255",maxMessage="Ошибка в поле 'Кол-во SIM'")
     */
    private $quantity_sim;

    /**
     * @var string
     *
     * @ORM\Column(name="camera", type="string", length=255, nullable=true)
     * @Assert\Length(
     *     min="2",minMessage="Ошибка в поле 'Камера'",
     *     max="255",maxMessage="Ошибка в поле 'Камера'")
     */
    private $camera;

    /**
     * @var string
     *
     * @ORM\Column(name="weight", type="string", length=255, nullable=true)
     * @Assert\Length(
     *     min="2",minMessage="Ошибка в поле 'Вес'",
     *     max="255",maxMessage="Ошибка в поле 'Вес")
     */
    private $weight;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     *
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="guarantee", type="string", length=255, nullable=true)
     * @Assert\Length(
     *     min="2",minMessage="Ошибка в поле 'Гаранития'",
     *     max="255",maxMessage="Ошибка в поле 'Гарантия'")
     */
    private $guarantee;

    /**
     * @var string
     *
     * @ORM\Column(name="availability_sim", type="string", length=255, nullable=true)
     * @Assert\Length(
     *     min="2",minMessage="Ошибка в поле 'Наличие SIM'",
     *     max="255",maxMessage="Ошибка в поле 'Наличие SIM")
     */
    private $availability_sim;

    /**
     * @var string
     *
     * @ORM\Column(name="type_ram", type="string", length=255, nullable=true)
     * @Assert\Length(
     *     min="2",minMessage="Ошибка в поле 'Тип RAM'",
     *     max="255",maxMessage="Ошибка в поле 'Тип RAM'")
     */
    private $type_ram;

    /**
     * @var string
     *
     * @ORM\Column(name="quantity_socket_ram", type="string", length=255, nullable=true)
     * @Assert\Length(
     *     min="2",minMessage="Ошибка в поле 'Кол-во слотов RAM'",
     *     max="255",maxMessage="Ошибка в поле 'Кол-во слотов RAM'")
     */
    private $quantity_socket_ram;

    /**
     * @var string
     *
     * @ORM\Column(name="video_card", type="string", length=255, nullable=true)
     * @Assert\Length(
     *     min="2",minMessage="Ошибка в поле 'Графический адаптер'",
     *     max="255",maxMessage="Ошибка в поле 'Графический адаптер'")
     */
    private $video_card;

    /**
     * @var string
     *
     * @ORM\Column(name="network_adapter", type="string", length=255, nullable=true)
     * @Assert\Length(
     *     min="2",minMessage="Ошибка в поле 'Сетевой адаптер'",
     *     max="255",maxMessage="Ошибка в поле 'Сетевой адаптер'")
     */
    private $network_adapter;

    /**
     * @var string
     *
     * @ORM\Column(name="battery", type="string", length=255, nullable=true)
     * @Assert\Length(
     *     min="2",minMessage="Ошибка в поле 'Батарея'",
     *     max="255",maxMessage="Ошибка в поле 'Батарея'")
     */
    private $battery;

    public function __construct()
    {
        $date=new \DateTime("now");
        $this->setDataCreate($date);
        $this->photo=new ArrayCollection();
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

    /**
     * @return string
     */
    public function getIconFile()
    {
        return $this->iconFile;
    }

    /**
     * @param string $iconFile
     */
    public function setIconFile($iconFile)
    {
        $this->iconFile = $iconFile;
    }

    /**
     * @return string
     */
    public function getOs()
    {
        return $this->os;
    }

    /**
     * @param string $os
     */
    public function setOs($os)
    {
        $this->os = $os;
    }

    /**
     * @return string
     */
    public function getScreenSize()
    {
        return $this->screen_size;
    }

    /**
     * @param string $screen_size
     */
    public function setScreenSize($screen_size)
    {
        $this->screen_size = $screen_size;
    }

    /**
     * @return string
     */
    public function getScreenResolution()
    {
        return $this->screen_resolution;
    }

    /**
     * @param string $screen_resolution
     */
    public function setScreenResolution($screen_resolution)
    {
        $this->screen_resolution = $screen_resolution;
    }

    /**
     * @return string
     */
    public function getTypeScreen()
    {
        return $this->type_screen;
    }

    /**
     * @param string $type_screen
     */
    public function setTypeScreen($type_screen)
    {
        $this->type_screen = $type_screen;
    }

    /**
     * @return string
     */
    public function getProcessor()
    {
        return $this->processor;
    }

    /**
     * @param string $processor
     */
    public function setProcessor($processor)
    {
        $this->processor = $processor;
    }

    /**
     * @return string
     */
    public function getRam()
    {
        return $this->ram;
    }

    /**
     * @param string $ram
     */
    public function setRam($ram)
    {
        $this->ram = $ram;
    }

    /**
     * @return string
     */
    public function getQuantitySim()
    {
        return $this->quantity_sim;
    }

    /**
     * @param string $quantity_sim
     */
    public function setQuantitySim($quantity_sim)
    {
        $this->quantity_sim = $quantity_sim;
    }

    /**
     * @return string
     */
    public function getCamera()
    {
        return $this->camera;
    }

    /**
     * @param string $camera
     */
    public function setCamera($camera)
    {
        $this->camera = $camera;
    }

    /**
     * @return string
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * @param string $weight
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getGuarantee()
    {
        return $this->guarantee;
    }

    /**
     * @param string $guarantee
     */
    public function setGuarantee($guarantee)
    {
        $this->guarantee = $guarantee;
    }

    /**
     * @return string
     */
    public function getAvailabilitySim()
    {
        return $this->availability_sim;
    }

    /**
     * @param string $availability_sim
     */
    public function setAvailabilitySim($availability_sim)
    {
        $this->availability_sim = $availability_sim;
    }

    /**
     * @return string
     */
    public function getTypeRam()
    {
        return $this->type_ram;
    }

    /**
     * @param string $type_ram
     */
    public function setTypeRam($type_ram)
    {
        $this->type_ram = $type_ram;
    }

    /**
     * @return string
     */
    public function getQuantitySocketRam()
    {
        return $this->quantity_socket_ram;
    }

    /**
     * @param string $quantity_socket_ram
     */
    public function setQuantitySocketRam($quantity_socket_ram)
    {
        $this->quantity_socket_ram = $quantity_socket_ram;
    }

    /**
     * @return string
     */
    public function getVideoCard()
    {
        return $this->video_card;
    }

    /**
     * @param string $video_card
     */
    public function setVideoCard($video_card)
    {
        $this->video_card = $video_card;
    }

    /**
     * @return string
     */
    public function getNetworkAdapter()
    {
        return $this->network_adapter;
    }

    /**
     * @param string $network_adapter
     */
    public function setNetworkAdapter($network_adapter)
    {
        $this->network_adapter = $network_adapter;
    }

    /**
     * @return string
     */
    public function getBattery()
    {
        return $this->battery;
    }

    /**
     * @param string $battery
     */
    public function setBattery($battery)
    {
        $this->battery = $battery;
    }


}
