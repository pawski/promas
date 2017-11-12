<?php
declare(strict_types=1);
namespace Enginewerk\Promas\SearchBundle\Finder\Doctrine;

use Doctrine\ORM\EntityManagerInterface;
use Enginewerk\Promas\SearchBundle\Finder\FinderInterface;

class Finder implements FinderInterface
{
    /** @var EntityManagerInterface */
    private $entityManager;

    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function findByInvestment(string $investmentIdentifier)
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();
        $queryBuilder
            ->select('p.identifier, p.area, p.price, p.floor, p.type, p.available')
            ->from('PromasPropertyBundle:Investment', 'investment')
            ->leftJoin('investment.properties', 'p')
            ->where($queryBuilder->expr()->eq('investment.name', ':investment'))
            ->setParameter('investment', $investmentIdentifier);

        return $queryBuilder->getQuery()->getArrayResult();
    }
}
