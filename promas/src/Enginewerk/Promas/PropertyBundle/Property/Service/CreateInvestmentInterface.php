<?php
declare(strict_types=1);
namespace Enginewerk\Promas\PropertyBundle\Property\Service;

use Enginewerk\Promas\PropertyBundle\Property\Command\CreateInvestmentCommand;

interface CreateInvestmentInterface
{
    public function createInvestment(CreateInvestmentCommand $createInvestmentCommand): void;
}
