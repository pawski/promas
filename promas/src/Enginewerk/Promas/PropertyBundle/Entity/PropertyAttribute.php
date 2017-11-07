<?php
declare(strict_types=1);
namespace Enginewerk\Promas\PropertyBundle\Entity;

class PropertyAttribute
{
    /** @var integer */
    private $id;

    /** @var string  */
    private $identifier;

    /** @var string */
    private $value;

    /** @var Property */
    private $property;

    public function getId()
    {
        return $this->id;
    }

    public function setValue(string $value)
    {
        $this->value = $value;

        return $this;
    }

    public function getValue():? string
    {
        return $this->value;
    }

    public function setProperty(Property $property = null)
    {
        $this->property = $property;

        return $this;
    }

    public function getProperty():? Property
    {
        return $this->property;
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
}
