<?php
namespace Unoegohh\EntitiesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="Unoegohh\EntitiesBundle\Repository\ItemRepository")
 * @ORM\Table(name="item")
 */
class Item
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     */
    protected $name;

    /**
     * @ORM\Column(type="boolean",nullable=true)
     */
    protected $top;

    /**
     * @ORM\Column(type="integer",nullable=true)
     */
    protected $itemOrder;

    /**
     * @ORM\Column(type="string", length=65500, nullable=true)
     */
    protected $description;


    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $active;

    /**
     * @ORM\OneToMany(targetEntity="Unoegohh\EntitiesBundle\Entity\ItemImage", mappedBy="item_id", cascade={"remove", "persist"})
     **/
    protected $photos;

    /**
     * @ORM\ManyToOne(targetEntity="Unoegohh\EntitiesBundle\Entity\ItemCategory", inversedBy="items")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     **/
    protected $category_id;

    function __construct()
    {
        $this->photos = new ArrayCollection();
    }

    /**
     * @param mixed $active
     */
    public function setActive($active)
    {
        $this->active = $active;
    }

    /**
     * @return mixed
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * @param mixed $category_id
     */
    public function setCategoryId($category_id)
    {
        $this->category_id = $category_id;
    }

    /**
     * @return mixed
     */
    public function getCategoryId()
    {
        return $this->category_id;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $photos
     */
    public function setPhotos($photos)
    {
        $this->photos = $photos;
    }

    /**
     * @return mixed
     */
    public function getPhotos()
    {
        return $this->photos;
    }

    /**
     * @param mixed $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

    /**
     * @param mixed $top
     */
    public function setTop($top)
    {
        $this->top = $top;
    }

    /**
     * @return mixed
     */
    public function getTop()
    {
        return $this->top;
    }

    /**
     * @param mixed $itemOrder
     */
    public function setItemOrder($itemOrder)
    {
        $this->itemOrder = $itemOrder;
    }

    /**
     * @return mixed
     */
    public function getItemOrder()
    {
        return $this->itemOrder;
    }


}