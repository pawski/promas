<?php
declare(strict_types=1);
namespace Enginewerk\Promas\PropertyBundle\Property\Service;

use Enginewerk\Promas\PropertyBundle\Property\Command\CreatePropertyCommand;
use Enginewerk\Promas\PropertyBundle\Property\Command\UpdatePropertyCommand;

interface CreateAndUpdatePropertyInterface
{
    public function createProperty(CreatePropertyCommand $createPropertyCommand): void;

    public function updateProperty(UpdatePropertyCommand $updatePropertyCommand): void;
}
