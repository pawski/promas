<?php
declare(strict_types=1);
namespace Enginewerk\Promas\PropertyBundle\Property\Command;

use Enginewerk\Common\Collection\AbstractRestrictedArrayCollection;

class UpdatePropertyCommandCollection extends AbstractRestrictedArrayCollection
{
    const ELEMENT_TYPE = UpdatePropertyCommand::class;
}
