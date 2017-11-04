<?php
declare(strict_types=1);
namespace Enginewerk\Promas\ImportBundle\Xl\Model;

class XlProperty
{
    /** @var string */
    private $identifier;

    /** @var string  */
    private $price;

    /** @var string */
    private $area;

    /** @var string */
    private $room;

    /** @var int */
    private $available;

    /** @var string */
    private $mezzanine;

    public function __construct(string $identifier, string $price, string $area, string $room, int $available, string $mezzanine)
    {
        $this->identifier = $identifier;
        $this->price = $price;
        $this->area = $area;
        $this->room = $room;
        $this->available = $available;
        $this->mezzanine = $mezzanine;
    }

    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    public function getPrice(): string
    {
        return $this->price;
    }

    public function getArea(): string
    {
        return $this->area;
    }

    public function getRoom(): string
    {
        return $this->room;
    }

    public function getAvailable(): int
    {
        return $this->available;
    }

    public function getMezzanine(): string
    {
        return $this->mezzanine;
    }
}
