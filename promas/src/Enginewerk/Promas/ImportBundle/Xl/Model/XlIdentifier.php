<?php
declare(strict_types=1);
namespace Enginewerk\Promas\ImportBundle\Xl\Model;

final class XlIdentifier
{
    const DELIMITER = '_';

    /** @var string */
    private $investment;

    /** @var string */
    private $propertyType;

    /** @var string */
    private $propertyIdentifier;

    public function __construct(string $investment, string $propertyType, string $propertyIdentifier)
    {
        $this->investment = $investment;
        $this->propertyType = $propertyType;
        $this->propertyIdentifier = $propertyIdentifier;
    }

    public function getInvestment(): string
    {
        return $this->investment;
    }

    public function getPropertyType(): string
    {
        return $this->propertyType;
    }

    public function getPropertyIdentifier(): string
    {
        return $this->propertyIdentifier;
    }
}
