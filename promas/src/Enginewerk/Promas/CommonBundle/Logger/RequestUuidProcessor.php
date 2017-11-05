<?php declare(strict_types=1);
namespace Enginewerk\Promas\CommonBundle\Logger;

use Enginewerk\Common\Uuid\UuidGeneratorInterface;

class RequestUuidProcessor
{
    /** @var UuidGeneratorInterface */
    private $uuidGenerator;

    /** @var string */
    private $reference;

    /**
     * @param UuidGeneratorInterface $uuidGenerator
     */
    public function __construct(UuidGeneratorInterface $uuidGenerator)
    {
        $this->uuidGenerator = $uuidGenerator;
    }

    /**
     * @param array $record
     *
     * @return array
     */
    public function processRecord(array $record): array
    {
        $record['extra']['requestUuid'] = $this->getReference();

        return $record;
    }

    /**
     * @return string
     */
    public function getReference(): string
    {
        if (null === $this->reference) {
            $this->reference = $this->uuidGenerator->generate();
        }

        return $this->reference;
    }

    /**
     * @param string $reference
     */
    public function setReference(string $reference): void
    {
        $this->reference = $reference;
    }
}
