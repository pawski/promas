<?php
declare(strict_types=1);
namespace Enginewerk\Promas\PropertyBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class Property
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $identifier;

    /**
     * @var integer
     */
    private $area;

    /**
     * @var integer
     */
    private $price;

    /**
     * @var string
     */
    private $type;

    /**
     * @var int
     */
    private $floor;

    /**
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @var Investment
     */
    private $investment;

    /**
     * @var Collection
     */
    private $propertyAttributes;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->propertyAttributes = new ArrayCollection();
    }


    /**
     * Get id
     *
     * @return integer
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Set identifier
     *
     * @param string $identifier
     *
     * @return Property
     */
    public function setIdentifier(string $identifier)
    {
        $this->identifier = $identifier;

        return $this;
    }

    /**
     * Get identifier
     *
     * @return string
     */
    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    /**
     * Set area
     *
     * @param integer $area
     *
     * @return Property
     */
    public function setArea(int $area)
    {
        $this->area = $area;

        return $this;
    }

    /**
     * Get area
     *
     * @return integer
     */
    public function getArea(): int
    {
        return $this->area;
    }

    /**
     * Set price
     *
     * @param integer $price
     *
     * @return Property
     */
    public function setPrice(int $price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return integer
     */
    public function getPrice():? int
    {
        return $this->price;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Property
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return Property
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set investment
     *
     * @param Investment $investment
     *
     * @return Property
     */
    public function setInvestment(Investment $investment = null)
    {
        $this->investment = $investment;

        return $this;
    }

    /**
     * Get investment
     *
     * @return Investment
     */
    public function getInvestment(): Investment
    {
        return $this->investment;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return Property
     */
    public function setType(string $type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * Set floor
     *
     * @param int $floor
     *
     * @return Property
     */
    public function setFloor(int $floor)
    {
        $this->floor = $floor;

        return $this;
    }

    /**
     * Get floor
     *
     * @return int
     */
    public function getFloor(): int
    {
        return $this->floor;
    }

    /**
     * Add propertyAttribute
     *
     * @param PropertyAttribute $propertyAttribute
     */
    public function addPropertyAttribute(PropertyAttribute $propertyAttribute)
    {
        $this->propertyAttributes->add($propertyAttribute);
    }

    /**
     * Remove propertyAttribute
     *
     * @param PropertyAttribute $propertyAttribute
     */
    public function removePropertyAttribute(PropertyAttribute $propertyAttribute)
    {
        $this->propertyAttributes->removeElement($propertyAttribute);
    }

    /**
     * Get propertyAttributes
     *
     * @return ArrayCollection
     */
    public function getPropertyAttributes(): ArrayCollection
    {
        return $this->propertyAttributes;
    }
}
