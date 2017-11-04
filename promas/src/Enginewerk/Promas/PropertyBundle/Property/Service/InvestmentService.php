<?php
declare(strict_types=1);
namespace Enginewerk\Promas\PropertyBundle\Property\Service;

use Enginewerk\Common\Date\DateTimeReaderInterface;
use Enginewerk\Common\Uuid\UuidGeneratorInterface;
use Enginewerk\Promas\PropertyBundle\Entity\Investment;
use Enginewerk\Promas\PropertyBundle\Property\Command\CreateInvestmentCommand;
use Enginewerk\Promas\PropertyBundle\Repository\InvestmentRepositoryInterface;

class InvestmentService implements CreateInvestmentInterface
{
    /** @var InvestmentRepositoryInterface */
    private $investmentRepository;

    /** @var UuidGeneratorInterface */
    private $uuidGenerator;

    /** @var DateTimeReaderInterface */
    private $dateTimeReader;

    public function __construct(
        InvestmentRepositoryInterface $investmentRepository,
        UuidGeneratorInterface $uuidGenerator,
        DateTimeReaderInterface $dateTimeReader
    ) {
        $this->investmentRepository = $investmentRepository;
        $this->uuidGenerator = $uuidGenerator;
        $this->dateTimeReader = $dateTimeReader;
    }

    public function createInvestment(CreateInvestmentCommand $createInvestmentCommand): void
    {
        $investment = new Investment();
        $investment->setUuid($this->uuidGenerator->generate());
        $investment->setName($createInvestmentCommand->getInvestmentName());
        $investment->setNameCanonical($this->createCanonicalName($createInvestmentCommand->getInvestmentName()));

        $currentDateTime = $this->dateTimeReader->getCurrentDateTime();
        $investment->setCreatedAt($currentDateTime);
        $investment->setUpdatedAt($currentDateTime);

        $this->investmentRepository->persist($investment);
    }

    private function createCanonicalName(string $name): string
    {
        return str_replace([' '],['_'], trim(ltrim($name)));
    }
}
