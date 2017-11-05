<?php
declare(strict_types=1);
namespace Enginewerk\Promas\ImportBundle\Command;

use Enginewerk\Promas\CommonBundle\Command\AbstractCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UpdateXlCommand extends AbstractCommand
{
    const COMMAND_NAME = 'promas:update:xl';
    const ARGUMENT_SOURCE = 'source';

    protected function configure()
    {
        $this->setName(static::COMMAND_NAME)
            ->addArgument(static::ARGUMENT_SOURCE, InputArgument::REQUIRED);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        parent::execute($input, $output);

        $requestData = file_get_contents($this->getInput()->getArgument(self::ARGUMENT_SOURCE));

        $struct = \GuzzleHttp\json_decode($requestData, false);
        $this->getContainer()
            ->get('enginewerk_promas_import.service.xl_import_service')
            ->updateFromJson($struct);
    }
}
