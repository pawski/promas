<?php
declare(strict_types=1);
namespace Enginewerk\Promas\ImportBundle\Xl\Transformer;

use Enginewerk\Promas\ImportBundle\Xl\Model\XlProperty;
use Enginewerk\Promas\ImportBundle\Xl\Model\XlPropertyCollection;

class JsonToCollectionTransformer
{
    public function transform(\stdClass $decodedCollection): XlPropertyCollection
    {
        $xlPropertyCollection = new XlPropertyCollection();

        foreach ($decodedCollection as $key => $item) {
            $property = new XlProperty(
                $key,
                $item->price,
                $item->area,
                $item->room,
                $item->available,
                $item->mezzanine
            );
            $xlPropertyCollection->add($property);
        }

        return $xlPropertyCollection;
    }
}
