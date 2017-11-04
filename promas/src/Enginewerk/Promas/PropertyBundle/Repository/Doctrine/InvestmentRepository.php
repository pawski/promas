<?php
declare(strict_types=1);
namespace Enginewerk\Promas\PropertyBundle\Repository\Doctrine;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException as DoctrineNoResultException;
use Enginewerk\Promas\PropertyBundle\Entity\Investment as InvestmentEntity;
use Enginewerk\Promas\PropertyBundle\Repository\InvestmentFinderInterface;
use Enginewerk\Promas\PropertyBundle\Repository\InvestmentRepositoryInterface;
use Enginewerk\Promas\PropertyBundle\Repository\NoResultException;

class InvestmentRepository extends EntityRepository implements InvestmentRepositoryInterface, InvestmentFinderInterface
{
    public function getByName(string $name): InvestmentEntity
    {
        $queryBuilder = $this->createQueryBuilder('investment');
        $queryBuilder
            ->where($queryBuilder->expr()->eq('investment.name', ':name'))
            ->setParameter('name', $name);

        try {
            return $queryBuilder->getQuery()->getSingleResult();
        } catch (DoctrineNoResultException $noResultException) {
            throw new NoResultException(sprintf('Expected entity "%s", got none', InvestmentEntity::class));
        }
    }

    public function remove(InvestmentEntity $investment): void
    {
        $this->getEntityManager()->remove($investment);
        $this->getEntityManager()->flush();
    }


    public function persist(InvestmentEntity $investment): void
    {
        $this->getEntityManager()->persist($investment);
        $this->getEntityManager()->flush();
    }
}
