<?php

namespace MyShop\DefBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Pages
 *
 * @ORM\Table(name="pages")
 * @ORM\Entity(repositoryClass="MyShop\DefBundle\Repository\PagesRepository")
 */
class Pages
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
     * @ORM\Column(name="content", type="text")
     */
    private $content;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="pageURL", type="string", length=255, unique=true)
     */
    private $pageURL;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dataCreated", type="datetime")
     */
    private $dataCreated;

    public function __construct()
    {
        $this->setDataCreated(new \DateTime('now'));
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
     * Set content
     *
     * @param string $content
     *
     * @return Pages
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Pages
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set pageURL
     *
     * @param string $pageURL
     *
     * @return Pages
     */
    public function setPageURL($pageURL)
    {
        $this->pageURL = $pageURL;

        return $this;
    }

    /**
     * Get pageURL
     *
     * @return string
     */
    public function getPageURL()
    {
        return $this->pageURL;
    }

    /**
     * Set dataCreated
     *
     * @param \DateTime $dataCreated
     *
     * @return Pages
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
}

