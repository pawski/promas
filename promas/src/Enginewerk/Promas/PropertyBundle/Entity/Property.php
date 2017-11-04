<?php
declare(strict_types=1);
namespace Enginewerk\Promas\PropertyBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class Property
{
    /** @var integer */
    private $id;

    /** @var string */
    private $identifier;

    /** @var integer */
    private $area;

    /** @var integer */
    private $price;

    /** @var string */
    private $type;

    /** @var int */
    private $floor;

    /** @var boolean */
    private $available;

    /** @var \DateTime */
    private $createdAt;

    /** @var \DateTime */
    private $updatedAt;

    /** @var Investment */
    private $investment;

    /** @var integer */
    private $roomNumber;

    /** @var Collection */
    private $propertyAttributes;

    public function __construct()
    {
        $this->propertyAttributes = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setIdentifier(string $identifier)
    {
        $this->identifier = $identifier;

        return $this;
    }

    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    public function setArea(int $area)
    {
        $this->area = $area;

        return $this;
    }

    public function getArea(): int
    {
        return $this->area;
    }

    public function setPrice(int $price)
    {
        $this->price = $price;

        return $this;
    }

    public function getPrice():? int
    {
        return $this->price;
    }

    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    public function setUpdatedAt(\DateTime $updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getUpdatedAt(): \DateTime
    {
        return $this->updatedAt;
    }

    public function setInvestment(Investment $investment = null): Property
    {
        $this->investment = $investment;

        return $this;
    }

    public function getInvestment(): Investment
    {
        return $this->investment;
    }

    public function setType(string $type)
    {
        $this->type = $type;

        return $this;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setFloor(int $floor)
    {
        $this->floor = $floor;

        return $this;
    }

    public function getFloor(): int
    {
        return $this->floor;
    }

    public function addPropertyAttribute(PropertyAttribute $propertyAttribute)
    {
        $this->propertyAttributes->add($propertyAttribute);
    }

    public function removePropertyAttribute(PropertyAttribute $propertyAttribute)
    {
        $this->propertyAttributes->removeElement($propertyAttribute);
    }

    public function getPropertyAttributes(): ArrayCollection
    {
        return $this->propertyAttributes;
    }

    public function setAvailable(bool $available)
    {
        $this->available = $available;

        return $this;
    }

    public function getAvailable(): bool
    {
        return $this->available;
    }

    public function setRoomNumber(int $roomNumber)
    {
        $this->roomNumber = $roomNumber;

        return $this;
    }

    public function getRoomNumber(): int
    {
        return $this->roomNumber;
    }
}
