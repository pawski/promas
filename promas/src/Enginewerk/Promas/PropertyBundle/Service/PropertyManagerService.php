<?php
declare(strict_types=1);
namespace Enginewerk\Promas\PropertyBundle\Service;

use Enginewerk\Promas\PropertyBundle\Model\Investment;
use Enginewerk\Promas\PropertyBundle\Model\Property;
use Enginewerk\Promas\PropertyBundle\Model\PropertyCollection;
use Enginewerk\Promas\PropertyBundle\Property\Command\CreateInvestmentCommand;
use Enginewerk\Promas\PropertyBundle\Property\Command\CreatePropertyCommand;
use Enginewerk\Promas\PropertyBundle\Property\Command\UpdatePropertyCommand;
use Enginewerk\Promas\PropertyBundle\Property\Command\UpdatePropertyCommandCollection;
use Enginewerk\Promas\PropertyBundle\Property\Service\CreateAndUpdatePropertyInterface;
use Enginewerk\Promas\PropertyBundle\Property\Service\CreateInvestmentInterface;
use Enginewerk\Promas\PropertyBundle\Property\Service\PropertyUpdateService;

class PropertyManagerService
{
    /** @var CreateInvestmentInterface */
    private $investmentService;

    /** @var CreateAndUpdatePropertyInterface */
    private $propertyService;

    /** @var PropertyUpdateService */
    private $propertyUpdateService;

    public function __construct(
        CreateInvestmentInterface $investmentService,
        CreateAndUpdatePropertyInterface $propertyService,
        PropertyUpdateService $propertyUpdateService
    ) {
        $this->investmentService = $investmentService;
        $this->propertyService = $propertyService;
        $this->propertyUpdateService = $propertyUpdateService;
    }

    public function createInvestment(Investment $investment): void
    {
        // Add Validation
        $this->investmentService->createInvestment(new CreateInvestmentCommand($investment->getInvestmentName()));
    }

    public function createProperty(Property $property): void
    {
        // Add Validation
        $this->propertyService->createProperty(new CreatePropertyCommand(
            $property->getInvestmentName(),
            $property->getIdentifier(),
            $property->getArea(),
            $property->getPrice(),
            $property->getType(),
            $property->getFloor(),
            $property->getRoomNumber(),
            $property->isAvailable()
        ));
    }

    public function propertyDifferentialUpdate(Investment $investment, PropertyCollection $propertyCollection): void
    {
        $updatePropertyCommandCollection = new UpdatePropertyCommandCollection();

        foreach ($propertyCollection as $property) {
            $updatePropertyCommandCollection->add(new UpdatePropertyCommand(
                $property->getInvestmentName(),
                $property->getIdentifier(),
                $property->getArea(),
                $property->getPrice(),
                $property->getType(),
                $property->getFloor(),
                $property->getRoomNumber(),
                $property->isAvailable()
            ));
        }

        $this->propertyUpdateService->diffUpdate($investment, $updatePropertyCommandCollection);
    }
}
