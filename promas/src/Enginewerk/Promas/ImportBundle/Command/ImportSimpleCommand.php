<?php
declare(strict_types=1);
namespace Enginewerk\Promas\ImportBundle\Command;

use Enginewerk\Promas\CommonBundle\Command\AbstractSimpleCommand;

class ImportSimpleCommand extends AbstractSimpleCommand
{
    const COMMAND_NAME = 'promas:import';

    protected function executeCommand()
    {
        $this->getOutput()->writeln('Hello');
    }
}
