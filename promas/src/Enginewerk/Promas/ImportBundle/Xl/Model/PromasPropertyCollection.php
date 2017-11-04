<?php
declare(strict_types=1);
namespace Enginewerk\Promas\ImportBundle\Xl\Model;

use Enginewerk\Common\Collection\AbstractRestrictedArrayCollection;
use Enginewerk\Promas\ImportBundle\Xl\Model\PromasProperty;

final class PromasPropertyCollection extends AbstractRestrictedArrayCollection
{
    const ELEMENT_TYPE = PromasProperty::class;
}
