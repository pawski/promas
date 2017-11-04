<?php
declare(strict_types=1);
namespace Enginewerk\Promas\PropertyBundle\Repository;

use Enginewerk\Promas\PropertyBundle\Entity\Property as PropertyEntity;

interface PropertyRepositoryInterface
{
    /**
     * @param PropertyEntity $property
     *
     * @return void
     */
    public function remove(PropertyEntity $property): void;

    /**
     * @param PropertyEntity $property
     *
     * @return void
     */
    public function persist(PropertyEntity $property): void;
}
