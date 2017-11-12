<?php
declare(strict_types=1);
namespace Enginewerk\Promas\SearchBundle\Finder;

interface FinderInterface
{
    public function findByInvestment(string $investmentIdentifier);
}
