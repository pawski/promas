<?php
declare(strict_types=1);
namespace Enginewerk\Promas\PropertyBundle\Repository;

use Enginewerk\Promas\PropertyBundle\Entity\Property;
use Enginewerk\Promas\PropertyBundle\Entity\PropertyCollection;

interface PropertyFinderInterface
{
    public function getByIdentifierAndInvestmentId(string $identifier, int $investmentId): Property;

    public function findByInvestmentId(int $investment): PropertyCollection;
}
