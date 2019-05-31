<?php

namespace App;

use App\Factories\ProductProvider;
use App\Interfaces\ProductProviderInterface;
use TypeError;

final class GildedRose
{
    /** @var iterable */
    private $items = [];

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
        foreach ($this->items as $item) {
            if ($item->name !== 'Aged Brie' && $item->name !== 'Backstage passes to a TAFKAL80ETC concert') {
                if ($item->quality > 0) {
                    if ($item->name !== 'Sulfuras, Hand of Ragnaros') {
                        --$item->quality;
                    } else {
                        $item->quality = 80;
                    }
                }
            } elseif ($item->quality < 50) {
                ++$item->quality;
                if ($item->name === 'Backstage passes to a TAFKAL80ETC concert') {
                    if ($item->quality < 50) {
                        if ($item->sell_in < 11) {
                            ++$item->quality;
                        }
                        if ($item->sell_in < 6) {
                            ++$item->quality;
                        }
                    }
                }
            }

            if ($item->name !== 'Sulfuras, Hand of Ragnaros') {
                --$item->sell_in;
            }

            if ($item->sell_in < 0) {
                if ($item->name !== 'Aged Brie') {
                    if ($item->name !== 'Backstage passes to a TAFKAL80ETC concert') {
                        if (($item->quality > 0) && $item->name !== 'Sulfuras, Hand of Ragnaros') {
                            --$item->quality;
                        }
                    } else {
                        $item->quality -= $item->quality;
                    }
                } elseif ($item->quality < 50) {
                    ++$item->quality;
                }
            }
        }
    }
}
