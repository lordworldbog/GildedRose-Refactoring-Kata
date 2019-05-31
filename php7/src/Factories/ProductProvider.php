<?php

namespace App\Factories;

use App\Entities\AgedBrie;
use App\Entities\BackstagePasses;
use App\Entities\Conjured;
use App\Entities\OrdinaryProduct;
use App\Entities\Sulfuras;
use App\Interfaces\ProductInterface;
use App\Interfaces\ProductProviderInterface;
use App\Item;

class ProductProvider implements ProductProviderInterface
{
    protected $products;

    public function __construct()
    {
        $this->products = [
            'Aged Brie'                                 => AgedBrie::class,
            'Sulfuras, Hand of Ragnaros'                => Sulfuras::class,
            'Backstage passes to a TAFKAL80ETC concert' => BackstagePasses::class,
            'Conjured Mana Cake'                        => Conjured::class,
        ];
    }

    public function createProductInstanceFrom(Item $item): ProductInterface
    {
        $itemName = $item->name;

        if (empty($this->products[$itemName])) {
            return new OrdinaryProduct($item);
        }

        return new $this->products[$itemName]($item);
    }
}
