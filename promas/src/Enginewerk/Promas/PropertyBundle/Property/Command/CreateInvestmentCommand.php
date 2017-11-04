<?php
declare(strict_types=1);
namespace Enginewerk\Promas\PropertyBundle\Property\Command;

final class CreateInvestmentCommand
{
    /**
     * @var string
     */
    private $investmentName;

    /**
     * @param string $investmentName
     */
    public function __construct(string $investmentName)
    {
        $this->investmentName = $investmentName;
    }

    public function getInvestmentName(): string
    {
        return $this->investmentName;
    }
}
