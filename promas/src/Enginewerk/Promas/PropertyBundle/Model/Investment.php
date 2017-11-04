<?php
declare(strict_types=1);
namespace Enginewerk\Promas\PropertyBundle\Model;

class Investment
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
