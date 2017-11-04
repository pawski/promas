<?php
declare(strict_types=1);
namespace Enginewerk\Promas\PropertyBundle\Repository;

use Enginewerk\Promas\PropertyBundle\Entity\Property;

interface PropertyFinderInterface
{
    public function getByIdentifierAndInvestment(string $identifier, int $investmentId): Property;
}
