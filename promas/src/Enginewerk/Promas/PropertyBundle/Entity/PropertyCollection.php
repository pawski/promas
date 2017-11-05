<?php
declare(strict_types=1);
namespace Enginewerk\Promas\PropertyBundle\Entity;

use Enginewerk\Common\Collection\AbstractRestrictedArrayCollection;

class PropertyCollection extends AbstractRestrictedArrayCollection
{
    const ELEMENT_TYPE = Property::class;
}
