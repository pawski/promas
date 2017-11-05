<?php
declare(strict_types=1);
namespace Enginewerk\Promas\PropertyBundle\Repository;

use Enginewerk\Promas\PropertyBundle\Entity\Property as PropertyEntity;
use Enginewerk\Promas\PropertyBundle\Entity\PropertyCollection;

interface PropertyRepositoryInterface
{
    public function remove(PropertyEntity $property): void;

    public function persist(PropertyEntity $property): void;

    public function bulkPersist(PropertyCollection $propertyCollection): void;
}
