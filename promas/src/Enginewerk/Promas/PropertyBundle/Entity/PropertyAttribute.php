<?php
declare(strict_types=1);
namespace Enginewerk\Promas\PropertyBundle\Entity;

class PropertyAttribute
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $value;

    /**
     * @var Property
     */
    private $property;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return PropertyAttribute
     */
    public function setName(string $name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Set value
     *
     * @param string $value
     *
     * @return PropertyAttribute
     */
    public function setValue(string $value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return string
     */
    public function getValue():? string
    {
        return $this->value;
    }

    /**
     * Set property
     *
     * @param Property $property
     *
     * @return PropertyAttribute
     */
    public function setProperty(Property $property = null)
    {
        $this->property = $property;

        return $this;
    }

    /**
     * Get property
     *
     * @return Property
     */
    public function getProperty():? Property
    {
        return $this->property;
    }
}

