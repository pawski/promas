<?php
declare(strict_types=1);
namespace Enginewerk\Promas\ImportBundle\Xl\Model;

class PromasProperty
{
    /** @var string */
    private $investment;

    /** @var string */
    private $identifier;

    /** @var int */
    private $price;

    /** @var float */
    private $area;

    /** @var int */
    private $room;

    /** @var string */
    private $type;

    /** @var bool */
    private $available;

    public function __construct(string $investment, string $identifier, int $price, float $area, int $room, string $type, bool $available)
    {
        $this->investment = $investment;
        $this->identifier = $identifier;
        $this->price = $price;
        $this->area = $area;
        $this->room = $room;
        $this->type = $type;
        $this->available = $available;
    }

    public function getInvestment(): string
    {
        return $this->investment;
    }

    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function getArea(): float
    {
        return $this->area;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getRoom(): int
    {
        return $this->room;
    }

    public function isAvailable(): bool
    {
        return $this->available;
    }
}
