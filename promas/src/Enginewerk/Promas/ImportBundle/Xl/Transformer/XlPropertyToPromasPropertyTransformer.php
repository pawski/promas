<?php
declare(strict_types=1);
namespace Enginewerk\Promas\ImportBundle\Xl\Transformer;

use Enginewerk\Promas\ImportBundle\Xl\Model\PromasProperty;
use Enginewerk\Promas\ImportBundle\Xl\Model\PromasPropertyCollection;
use Enginewerk\Promas\ImportBundle\Xl\Model\XlProperty;
use Enginewerk\Promas\ImportBundle\Xl\Model\XlPropertyCollection;

class XlPropertyToPromasPropertyTransformer
{
    /** @var XlIdentifierTransformer */
    private $xlIdentifierDecoder;

    /**
     * @param XlIdentifierTransformer $xlIdentifierDecoder
     */
    public function __construct(XlIdentifierTransformer $xlIdentifierDecoder)
    {
        $this->xlIdentifierDecoder = $xlIdentifierDecoder;
    }

    public function toPromasPropertyCollection(XlPropertyCollection $propertyCollection): PromasPropertyCollection
    {
        $promasPropertyCollection = new PromasPropertyCollection();
        /** @var XlProperty $xlProperty */
        foreach ($propertyCollection as $xlProperty) {
            $promasPropertyCollection->add($this->toPromasProperty($xlProperty));
        }

        return $promasPropertyCollection;
    }

    private function toPromasProperty(XlProperty $xlProperty): PromasProperty
    {
        $xlIdentifier = $this->xlIdentifierDecoder->toXlIdentifier($xlProperty->getIdentifier());

        return new PromasProperty(
            $xlIdentifier->getInvestment(),
            $xlIdentifier->getPropertyIdentifier(),
            $this->stringPriceToInteger($xlProperty->getPrice()),
            $this->stringAreaToFloat($xlProperty->getArea()),
            (int) $xlProperty->getRoom(),
            $xlIdentifier->getPropertyType(),
            (bool) $xlProperty->getAvailable()
        );
    }

    private function stringPriceToInteger(string $price):int
    {
        return (int) mb_substr($price, 0, mb_strpos($price, ',') + 1);
    }

    private function stringAreaToFloat(string $area): float
    {
        return (float) str_replace(',', '.', $area);
    }
}
