<?php
declare(strict_types=1);
namespace Enginewerk\Common\Logger;

use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

trait HasLoggerTrait
{
    /**
     * @var LoggerInterface
     */
    protected $logger;

    public function getLogger(): LoggerInterface
    {
        return $this->logger ?? new NullLogger();
    }

    public function setLogger(LoggerInterface $logger): void
    {
        $this->logger = $logger;
    }
}
