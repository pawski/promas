<?php
declare(strict_types=1);
namespace Enginewerk\Promas\PropertyBundle\Service;

use Enginewerk\Promas\PropertyBundle\Property\Command\CreateInvestmentCommand;
use Enginewerk\Promas\PropertyBundle\Property\Service\CreateInvestmentInterface;

class PropertyManagerService
{
    /** @var CreateInvestmentInterface */
    private $investmentService;

    /**
     * @param CreateInvestmentInterface $investmentService
     */
    public function __construct(CreateInvestmentInterface $investmentService)
    {
        $this->investmentService = $investmentService;
    }

    public function createInvestment(string $investmentName): void
    {
        $this->investmentService->createInvestment(new CreateInvestmentCommand($investmentName));
    }
}
