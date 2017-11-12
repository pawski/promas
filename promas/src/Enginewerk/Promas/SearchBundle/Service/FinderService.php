<?php
declare(strict_types=1);
namespace Enginewerk\Promas\SearchBundle\Service;

use Enginewerk\Promas\SearchBundle\Finder\FinderInterface;

class FinderService
{
    /** @var FinderInterface */
    private $finder;

    /**
     * @param FinderInterface $finder
     */
    public function __construct(FinderInterface $finder)
    {
        $this->finder = $finder;
    }

    public function findByInvestment(string $investmentIdentifier)
    {
        return $this->finder->findByInvestment($investmentIdentifier);
    }
}
