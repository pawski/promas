<?php
declare(strict_types=1);
namespace Enginewerk\Promas\ImportBundle\Service;

use Enginewerk\Promas\ImportBundle\Xl\Model\PromasProperty;
use Enginewerk\Promas\ImportBundle\Xl\Transformer\JsonToCollectionTransformer;
use Enginewerk\Promas\ImportBundle\Xl\Transformer\XlIdentifierTransformer;
use Enginewerk\Promas\ImportBundle\Xl\Transformer\XlPropertyToPromasPropertyTransformer;
use Enginewerk\Promas\PropertyBundle\Model\Property;
use Enginewerk\Promas\PropertyBundle\Service\PropertyManagerService;

class XlImportService
{
    /** @var PropertyManagerService */
    private $propertyManager;

    /**
     * @param PropertyManagerService $propertyManager
     */
    public function __construct(PropertyManagerService $propertyManager)
    {
        $this->propertyManager = $propertyManager;
    }

    public function importFromJson(\stdClass $decodedCollection)
    {
        $collection = (new JsonToCollectionTransformer())->transform($decodedCollection);

        $xlTransformer = new XlPropertyToPromasPropertyTransformer(new XlIdentifierTransformer());
        $promasCollection = $xlTransformer->toPromasPropertyCollection($collection);

        /** @var PromasProperty $promasProperty */
        foreach ($promasCollection as $promasProperty) {
            $property = new Property(
                $promasProperty->getInvestment(),
                $promasProperty->getIdentifier(),
                (int) ($promasProperty->getArea() * 100),
                $promasProperty->getPrice(),
                $promasProperty->getType(),
                0,
                $promasProperty->getRoom(),
                $promasProperty->isAvailable()
            );

            echo $property->getIdentifier() . PHP_EOL;
            $this->propertyManager->createProperty($property);
        }
    }
}
