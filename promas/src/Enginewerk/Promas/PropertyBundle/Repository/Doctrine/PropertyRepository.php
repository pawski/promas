<?php
declare(strict_types=1);
namespace Enginewerk\Promas\PropertyBundle\Repository\Doctrine;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException as DoctrineNoResultException;
use Enginewerk\Promas\PropertyBundle\Entity\PropertyCollection;
use Enginewerk\Promas\PropertyBundle\Repository\NoResultException;
use Enginewerk\Promas\PropertyBundle\Repository\PropertyFinderInterface;
use Enginewerk\Promas\PropertyBundle\Repository\PropertyRepositoryInterface;
use Enginewerk\Promas\PropertyBundle\Entity\Property as PropertyEntity;

class PropertyRepository extends EntityRepository implements PropertyRepositoryInterface, PropertyFinderInterface
{
    public function remove(PropertyEntity $property): void
    {
        $this->getEntityManager()->remove($property);
        $this->getEntityManager()->flush();
        $this->getEntityManager()->clear();
    }

    public function persist(PropertyEntity $property): void
    {
        $this->getEntityManager()->persist($property);
        $this->getEntityManager()->flush();
        $this->getEntityManager()->clear();
    }

    public function bulkPersist(PropertyCollection $propertyCollection): void
    {
        foreach ($propertyCollection as $propertyEntity) {
            $this->getEntityManager()->persist($propertyEntity);
        }

        $this->getEntityManager()->flush();
        $this->getEntityManager()->clear();
    }

    public function getByIdentifierAndInvestmentId(string $identifier, int $investmentId): PropertyEntity
    {
        $queryBuilder = $this->createQueryBuilder('property');
        $queryBuilder
            ->where($queryBuilder->expr()->eq('property.identifier', ':identifier'))
            ->setParameter('identifier', $identifier)
            ->andWhere($queryBuilder->expr()->eq('property.investment', ':investment'))
            ->setParameter('investment', $investmentId);

        try {
            return $queryBuilder->getQuery()->getSingleResult();
        } catch (DoctrineNoResultException $noResultException) {
            throw new NoResultException(sprintf('Expected entity "%s", got none', PropertyEntity::class));
        }
    }

    public function findByInvestmentId(int $investmentId): PropertyCollection
    {
        $queryBuilder = $this->createQueryBuilder('property');
        $queryBuilder
            ->where($queryBuilder->expr()->eq('property.investment', ':investment'))
            ->setParameter('investment', $investmentId);

        return new PropertyCollection($queryBuilder->getQuery()->getResult());
    }
}
