<?php
declare(strict_types=1);
namespace Enginewerk\Common\Date;

interface DateTimeReaderInterface
{
    /**
     * Returns DateTime object with current time
     *
     * @return \DateTime
     */
    public function getCurrentDateTime(): \DateTime;

    /**
     * Returns DateTimeImmutable object with current time
     *
     * @return \DateTimeImmutable
     */
    public function getCurrentDateTimeImmutable(): \DateTimeImmutable;
}
