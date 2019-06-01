<?php

namespace App;

use App\Factories\ProductProvider;
use App\Interfaces\ProductInterface;
use App\Interfaces\ProductProviderInterface;
use TypeError;

final class GildedRose
{
    /** @var array */
    private $items;

    public function __construct(iterable $items, ProductProviderInterface $factory = null)
    {
        $factory = $factory ?? new ProductProvider();

        foreach ($items as $item) {
            if (!$item instanceof Item) {
                throw new TypeError('Each item must be an instance of ' . Item::class);
            }
            $this->items[] = $factory->createProductInstanceFrom($item);
        }
    }

    public function updateQuality(): void
    {
        /** @var ProductInterface $item */
        foreach ($this->items as $item) {
            $item->updateAttributes();
        }
    }
}
