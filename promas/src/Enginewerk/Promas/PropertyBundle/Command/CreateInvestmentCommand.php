<?php
declare(strict_types=1);
namespace Enginewerk\Promas\PropertyBundle\Command;

use Enginewerk\Promas\CommonBundle\Command\AbstractCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class CreateInvestmentCommand extends AbstractCommand
{
    const COMMAND_NAME = 'promas:investment:create';
    const ARGUMENT_INVESTMENT = 'investment';

    protected function configure()
    {
        $this->setName(static::COMMAND_NAME)
            ->addArgument(static::ARGUMENT_INVESTMENT, InputArgument::REQUIRED);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        parent::execute($input, $output);

        $this->getContainer()
            ->get('enginewerk_promas_property.service.property_manager_service')
            ->createInvestment($this->getInput()->getArgument(static::ARGUMENT_INVESTMENT));
    }
}
