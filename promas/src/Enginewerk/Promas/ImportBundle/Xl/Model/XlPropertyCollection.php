<?php
declare(strict_types=1);
namespace Enginewerk\Promas\ImportBundle\Xl\Model;

use Enginewerk\Common\Collection\AbstractRestrictedArrayCollection;

final class XlPropertyCollection extends AbstractRestrictedArrayCollection
{
    const ELEMENT_TYPE = XlProperty::class;
}
