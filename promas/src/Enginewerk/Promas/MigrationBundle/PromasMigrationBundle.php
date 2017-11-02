<?php
namespace Enginewerk\Promas\MigrationBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class PromasMigrationBundle extends Bundle
{
    /**
     * @return string
     */
    public function getParent()
    {
        return 'DoctrineMigrationsBundle';
    }
}
