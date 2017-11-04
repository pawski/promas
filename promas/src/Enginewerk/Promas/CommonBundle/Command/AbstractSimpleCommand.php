<?php
declare(strict_types=1);
namespace Enginewerk\Promas\CommonBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

abstract class AbstractSimpleCommand extends ContainerAwareCommand
{
    const COMMAND_NAME = null;

    /** @var InputInterface */
    private $input;

    /** @var OutputInterface */
    private $output;

    /**
     * @inheritdoc
     */
    protected function configure()
    {
        $this
            ->setName(static::COMMAND_NAME);
    }

    abstract protected function executeCommand();

    /**
     * @inheritdoc
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->input = $input;
        $this->output = $output;

        $this->executeCommand();
    }

    protected function getInput(): InputInterface
    {
        return $this->input;
    }

    protected function getOutput(): OutputInterface
    {
        return $this->output;
    }
}
