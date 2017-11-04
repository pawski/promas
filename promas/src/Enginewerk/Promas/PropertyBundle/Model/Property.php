<?php
declare(strict_types=1);
namespace Enginewerk\Promas\PropertyBundle\Model;

final class Property
{
    /** @var string */
    private $investmentName;

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

    /** @var integer */
    private $roomNumber;

    /** @var bool */
    private $available;

    /**
     * @param string $investmentName
     * @param string $identifier
     * @param int $area
     * @param int $price
     * @param string $type
     * @param int $floor
     * @param int $roomNumber
     * @param bool $available
     */
    public function __construct(
        string $investmentName,
        string $identifier,
        int $area,
        int $price,
        string $type,
        int $floor,
        int $roomNumber,
        bool $available
    ) {
        $this->investmentName = $investmentName;
        $this->identifier = $identifier;
        $this->area = $area;
        $this->price = $price;
        $this->type = $type;
        $this->floor = $floor;
        $this->roomNumber = $roomNumber;
        $this->available = $available;
    }

    /**
     * @return string
     */
    public function getInvestmentName(): string
    {
        return $this->investmentName;
    }

    /**
     * @return string
     */
    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    /**
     * @return int
     */
    public function getArea(): int
    {
        return $this->area;
    }

    /**
     * @return int
     */
    public function getPrice(): int
    {
        return $this->price;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return int
     */
    public function getFloor(): int
    {
        return $this->floor;
    }

    /**
     * @return bool
     */
    public function isAvailable(): bool
    {
        return $this->available;
    }

    /**
     * @return int
     */
    public function getRoomNumber(): int
    {
        return $this->roomNumber;
    }
}
