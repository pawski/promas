<?php
declare(strict_types=1);
namespace Enginewerk\Promas\ImportBundle\Service;

use Enginewerk\Promas\ImportBundle\Xl\Model\PromasProperty;
use Enginewerk\Promas\ImportBundle\Xl\Transformer\JsonToCollectionTransformer;
use Enginewerk\Promas\ImportBundle\Xl\Transformer\XlIdentifierTransformer;
use Enginewerk\Promas\ImportBundle\Xl\Transformer\XlPropertyToPromasPropertyTransformer;
use Enginewerk\Promas\PropertyBundle\Model\Investment;
use Enginewerk\Promas\PropertyBundle\Model\Property;
use Enginewerk\Promas\PropertyBundle\Model\PropertyCollection;
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
            $property = $this->createProperty($promasProperty);
            $this->propertyManager->createProperty($property);
        }
    }

    public function updateFromJson(\stdClass $decodedCollection)
    {
        $collection = (new JsonToCollectionTransformer())->transform($decodedCollection);

        $xlTransformer = new XlPropertyToPromasPropertyTransformer(new XlIdentifierTransformer());
        $promasCollection = $xlTransformer->toPromasPropertyCollection($collection);

        $collectionByInvestment = [];
        /** @var PromasProperty $promasProperty */
        foreach ($promasCollection as $promasProperty) {
            $collectionByInvestment[$promasProperty->getInvestment()] = [];
        }

        /** @var PromasProperty $promasProperty */
        foreach ($promasCollection as $promasProperty) {
            $property = $this->createProperty($promasProperty);
            $collectionByInvestment[$promasProperty->getInvestment()][] = $property;
        }

        foreach ($collectionByInvestment as $investmentName => $properties) {
            $this->propertyManager->propertyDifferentialUpdate(
                new Investment($investmentName),
                new PropertyCollection($properties)
            );
        }
    }

    private function createProperty(PromasProperty $promasProperty): Property
    {
        return new Property(
            $promasProperty->getInvestment(),
            $promasProperty->getIdentifier(),
            (int)($promasProperty->getArea() * 100),
            $promasProperty->getPrice(),
            $promasProperty->getType(),
            0,
            $promasProperty->getRoom(),
            $promasProperty->isAvailable()
        );
    }
}
