<?php
declare(strict_types=1);
namespace Enginewerk\Promas\PropertyBundle\Service;

use Enginewerk\Promas\ImportBundle\Xl\Model\PromasProperty;
use Enginewerk\Promas\PropertyBundle\Model\Investment;
use Enginewerk\Promas\PropertyBundle\Model\Property;
use Enginewerk\Promas\PropertyBundle\Property\Command\CreateInvestmentCommand;
use Enginewerk\Promas\PropertyBundle\Property\Command\CreatePropertyCommand;
use Enginewerk\Promas\PropertyBundle\Property\Service\CreateAndUpdatePropertyInterface;
use Enginewerk\Promas\PropertyBundle\Property\Service\CreateInvestmentInterface;

class PropertyManagerService
{
    /** @var CreateInvestmentInterface */
    private $investmentService;

    /** @var CreateAndUpdatePropertyInterface */
    private $propertyService;

    public function __construct(
        CreateInvestmentInterface $investmentService,
        CreateAndUpdatePropertyInterface $propertyService
    ) {
        $this->investmentService = $investmentService;
        $this->propertyService = $propertyService;
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
}
