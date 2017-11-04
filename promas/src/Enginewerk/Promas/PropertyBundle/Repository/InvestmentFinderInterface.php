<?php
declare(strict_types=1);
namespace Enginewerk\Promas\PropertyBundle\Repository;

use Enginewerk\Promas\PropertyBundle\Entity\Investment;

interface InvestmentFinderInterface
{
    /**
     * @param string $name
     * @throws NoResultException
     * @return Investment
     */
    public function getByName(string $name): Investment;
}
