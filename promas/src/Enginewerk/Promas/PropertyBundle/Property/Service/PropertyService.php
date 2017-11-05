<?php
declare(strict_types=1);
namespace Enginewerk\Promas\PropertyBundle\Property\Service;

use Enginewerk\Common\Date\DateTimeReaderInterface;
use Enginewerk\Promas\PropertyBundle\Entity\Property;
use Enginewerk\Promas\PropertyBundle\Property\Command\CreatePropertyCommand;
use Enginewerk\Promas\PropertyBundle\Property\Command\UpdatePropertyCommand;
use Enginewerk\Promas\PropertyBundle\Repository\InvestmentFinderInterface;
use Enginewerk\Promas\PropertyBundle\Repository\PropertyFinderInterface;
use Enginewerk\Promas\PropertyBundle\Repository\PropertyRepositoryInterface;

class PropertyService implements CreateAndUpdatePropertyInterface
{
    /** @var InvestmentFinderInterface */
    private $investmentFinder;

    /** @var PropertyRepositoryInterface */
    private $propertyRepository;

    /** @var PropertyFinderInterface */
    private $propertyFinder;

    /** @var DateTimeReaderInterface */
    private $dateTimeReader;

    public function __construct(
        InvestmentFinderInterface $investmentFinder,
        PropertyRepositoryInterface $propertyRepository,
        PropertyFinderInterface $propertyFinder,
        DateTimeReaderInterface $dateTimeReader
    ) {
        $this->investmentFinder = $investmentFinder;
        $this->propertyRepository = $propertyRepository;
        $this->propertyFinder = $propertyFinder;
        $this->dateTimeReader = $dateTimeReader;
    }

    public function createProperty(CreatePropertyCommand $createPropertyCommand): void
    {
        $investment = $this->investmentFinder->getByName($createPropertyCommand->getInvestmentName());

        $property = new Property();
        $property->setArea($createPropertyCommand->getArea());
        $property->setAvailable($createPropertyCommand->isAvailable());
        $property->setFloor($createPropertyCommand->getFloor());
        $property->setIdentifier($createPropertyCommand->getIdentifier());
        $property->setInvestment($investment);
        $property->setPrice($createPropertyCommand->getPrice());
        $property->setType($createPropertyCommand->getType());
        $property->setRoomNumber($createPropertyCommand->getRoomNumber());

        $currentDateTime = $this->dateTimeReader->getCurrentDateTime();
        $property->setCreatedAt($currentDateTime);
        $property->setUpdatedAt($currentDateTime);

        $this->propertyRepository->persist($property);
    }

    public function updateProperty(UpdatePropertyCommand $updatePropertyCommand): void
    {
        $investment = $this->investmentFinder->getByName($updatePropertyCommand->getInvestmentName());
        $property = $this->propertyFinder->getByIdentifierAndInvestmentId(
            $updatePropertyCommand->getIdentifier(),
            $investment->getId()
        );

        $property->setArea($updatePropertyCommand->getArea());
        $property->setAvailable($updatePropertyCommand->isAvailable());
        $property->setFloor($updatePropertyCommand->getFloor());
        $property->setIdentifier($updatePropertyCommand->getIdentifier());
        $property->setPrice($updatePropertyCommand->getPrice());
        $property->setType($updatePropertyCommand->getType());
        $property->setRoomNumber($updatePropertyCommand->getRoomNumber());

        $currentDateTime = $this->dateTimeReader->getCurrentDateTime();
        $property->setUpdatedAt($currentDateTime);

        $this->propertyRepository->persist($property);
    }
}
