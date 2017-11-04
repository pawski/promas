<?php
declare(strict_types=1);
namespace Enginewerk\Promas\ImportBundle\Command;

use Enginewerk\Promas\CommonBundle\Command\AbstractSimpleCommand;
class ImportXlCommand extends AbstractSimpleCommand
{
    const COMMAND_NAME = 'promas:import:xl';

    protected function executeCommand()
    {
        //$filePath = '/vagrant/guest-shared-storage/request_2017-10-27_18-12-11__raw.log';
        $filePath = '/vagrant/guest-shared-storage/request_2017-10-27_19-01-26__raw.log';
        $requestData = file_get_contents($filePath);

        $struct = \GuzzleHttp\json_decode($requestData, false);
        $this->getContainer()
            ->get('enginewerk_promas_import.service.xl_import_service')
            ->importFromJson($struct);

    }
}
