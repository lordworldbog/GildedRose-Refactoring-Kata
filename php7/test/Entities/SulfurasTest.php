<?php

namespace Test\Entities;

use App\Entities\Sulfuras;
use App\Item;
use PHPUnit\Framework\TestCase;

class SulfurasTest extends TestCase
{
    public function testSulfuras_CantChangeSellIn(): void
    {
        $item = new Item('Sulfuras, Hand of Ragnaros', 3, 80);
        $product = new Sulfuras($item);
        $product->updateSellIn();
        $this->assertEquals(3, $item->sell_in);
    }

    public function testSulfuras_CantChangeQuality(): void
    {
        $item = new Item('Sulfuras, Hand of Ragnaros', 3, 80);
        $product = new Sulfuras($item);
        $product->updateQuality();
        $this->assertEquals(80, $item->quality);
    }

    public function testSulfuras_QualityIsSetEightyWhenCreated(): void
    {
        $item = new Item('Sulfuras, Hand of Ragnaros', 3, 50);
        new Sulfuras($item);
        $this->assertEquals(80, $item->quality);
    }
}
