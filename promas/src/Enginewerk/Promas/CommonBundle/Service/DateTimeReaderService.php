<?php
declare(strict_types=1);
namespace Enginewerk\Promas\CommonBundle\Service;

use Enginewerk\Common\Date\DateTimeReaderInterface;

final class DateTimeReaderService implements DateTimeReaderInterface
{
    /**
     * @var \DateTimeZone
     */
    private $dateTimeZone;

    /**
     * @param \DateTimeZone $dateTimeZone
     */
    public function __construct(\DateTimeZone $dateTimeZone)
    {
        $this->dateTimeZone = $dateTimeZone;
    }

    /**
     * @inheritdoc
     */
    public function getCurrentDateTimeImmutable(): \DateTimeImmutable
    {
        return new \DateTimeImmutable('now', $this->dateTimeZone);
    }

    /**
     * @inheritdoc
     */
    public function getCurrentDateTime(): \DateTime
    {
        return new \DateTime('now', $this->dateTimeZone);
    }
}
