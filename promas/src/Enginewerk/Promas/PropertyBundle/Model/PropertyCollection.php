<?php
declare(strict_types=1);
namespace Enginewerk\Promas\PropertyBundle\Model;

use Enginewerk\Common\Collection\AbstractRestrictedArrayCollection;

final class PropertyCollection extends AbstractRestrictedArrayCollection
{
    const ELEMENT_TYPE = Property::class;
}
