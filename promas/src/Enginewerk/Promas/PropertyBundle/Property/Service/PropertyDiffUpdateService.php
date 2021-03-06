<?php
declare(strict_types=1);
namespace Enginewerk\Promas\PropertyBundle\Property\Service;

use Enginewerk\Common\Date\DateTimeReaderInterface;
use Enginewerk\Common\Logger\HasLoggerTrait;
use Enginewerk\Promas\PropertyBundle\Entity\Property;
use Enginewerk\Promas\PropertyBundle\Entity\PropertyCollection;
use Enginewerk\Promas\PropertyBundle\Model\Investment;
use Enginewerk\Promas\PropertyBundle\Property\Command\UpdatePropertyCommand;
use Enginewerk\Promas\PropertyBundle\Property\Command\UpdatePropertyCommandCollection;
use Enginewerk\Promas\PropertyBundle\Repository\InvestmentFinderInterface;
use Enginewerk\Promas\PropertyBundle\Repository\PropertyFinderInterface;
use Enginewerk\Promas\PropertyBundle\Repository\PropertyRepositoryInterface;

class PropertyDiffUpdateService
{
    use HasLoggerTrait;

    /** @var PropertyRepositoryInterface */
    private $propertyRepository;

    /** @var PropertyFinderInterface */
    private $propertyFinder;

    /** @var InvestmentFinderInterface */
    private $investmentFinder;

    /** @var DateTimeReaderInterface */
    private $dateTimeReader;

    /**
     * @param PropertyRepositoryInterface $propertyRepository
     * @param PropertyFinderInterface $propertyFinder
     * @param InvestmentFinderInterface $investmentFinder
     * @param DateTimeReaderInterface $dateTimeReader
     */
    public function __construct(PropertyRepositoryInterface $propertyRepository, PropertyFinderInterface $propertyFinder, InvestmentFinderInterface $investmentFinder, DateTimeReaderInterface $dateTimeReader)
    {
        $this->propertyRepository = $propertyRepository;
        $this->propertyFinder = $propertyFinder;
        $this->investmentFinder = $investmentFinder;
        $this->dateTimeReader = $dateTimeReader;
    }

    public function update(Investment $investment, UpdatePropertyCommandCollection $propertyCommandCollection): void
    {
        $this->getLogger()->info('Running investment update', ['investment' => $investment->getInvestmentName()]);
        $investmentEntity = $this->investmentFinder->getByName($investment->getInvestmentName());
        $propertyCollection = $this->propertyFinder->findByInvestmentId($investmentEntity->getId());
        $propertyToUpdateCollection = new PropertyCollection();

        /** @var Property $property */
        foreach ($propertyCollection as $property) {
            $propertyUpdateCommand = $this->findByIdentifier($property->getIdentifier(), $propertyCommandCollection);
            if (null === $propertyUpdateCommand) {
                $this->getLogger()->debug(
                    'Can\'t find property in updateCollection',
                    ['identifier' => $property->getIdentifier()]
                );
                continue;
            }

            if ($this->needsUpdate($property, $propertyUpdateCommand)) {
                $property->setArea($propertyUpdateCommand->getArea());
                $property->setAvailable($propertyUpdateCommand->isAvailable());
                $property->setFloor($propertyUpdateCommand->getFloor());
                $property->setIdentifier($propertyUpdateCommand->getIdentifier());
                $property->setPrice($propertyUpdateCommand->getPrice());
                $property->setType($propertyUpdateCommand->getType());
                $property->setRoomNumber($propertyUpdateCommand->getRoomNumber());

                $currentDateTime = $this->dateTimeReader->getCurrentDateTime();
                $property->setUpdatedAt($currentDateTime);

                $propertyToUpdateCollection->add($property);
            }
        }

        $this->propertyRepository->bulkPersist($propertyToUpdateCollection);
    }

    private function needsUpdate(Property $property, UpdatePropertyCommand $updatePropertyCommand): bool
    {
        $propertyFields = [
            'available' => $property->getAvailable(),
            'area' => $property->getArea(),
            'floor' => $property->getFloor(),
            'room' => $property->getRoomNumber(),
            'type' => $property->getType(),
            'price' => $property->getPrice(),
        ];

        $updateFields = [
            'available' => $updatePropertyCommand->isAvailable(),
            'area' => $updatePropertyCommand->getArea(),
            'floor' => $updatePropertyCommand->getFloor(),
            'room' => $updatePropertyCommand->getRoomNumber(),
            'type' => $updatePropertyCommand->getType(),
            'price' => $updatePropertyCommand->getPrice(),
        ];

        $fieldsToUpdate = array_diff($propertyFields, $updateFields);

        $changes = [];
        foreach ($fieldsToUpdate as $fileName => $value) {
            $changes[$fileName] = [
                'from' => $propertyFields[$fileName],
                'to' => $updateFields[$fileName],
            ];
        }

        if (count($changes)) {
            $this->getLogger()->info(
                'Property update',
                [
                    'investment' => $updatePropertyCommand->getInvestmentName(),
                    'identifier' => $property->getIdentifier(),
                    'changes' => $changes
                ]
            );
        }

        return (bool) count(array_diff($propertyFields, $updateFields));
    }

    private function findByIdentifier(
        string $identifier,
        UpdatePropertyCommandCollection $propertyCommandCollection
    ):? UpdatePropertyCommand
    {
        $result = array_filter(
            $propertyCommandCollection->toArray(),
            function (UpdatePropertyCommand $val) use ($identifier) {
                return $identifier === $val->getIdentifier();
            },
            ARRAY_FILTER_USE_BOTH
        );

        switch (count($result) <=> 1) {
            case 0:
                $result = array_pop($result);
                break;
            case 1:
                $this->getLogger()->warning(
                    'More than one Property in updateCollection with same identifier',
                    ['query' => $identifier, 'collectionSize' => $propertyCommandCollection->count(), 'result' => $result]
                );
                $result = array_pop($result);
                break;
            case -1:
                $this->getLogger()->warning(
                    'Missing Property in updateCollection',
                    ['query' => $identifier, 'collectionSize' => $propertyCommandCollection->count()]
                );
                $result = null;
                break;
        }

        return $result;
    }
}
