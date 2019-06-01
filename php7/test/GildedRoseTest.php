<?php

namespace Test;

use App\Entities\AgedBrie;
use App\GildedRose;
use App\Item;
use PHPUnit\Framework\TestCase;
use TypeError;

class GildedRoseTest extends TestCase
{
    public function testGildedRoseConstructorAcceptsOnlyItems():void
    {
        $this->expectException(TypeError::class);
        $items = [new AgedBrie(new Item('AgedBrie', 0, 0))];
        new GildedRose($items);
    }

    public function testOrdinaryProductSellInCanBeBelowZeroAndQualityCant(): void
    {
        $items = [new Item('Ordinary product', 0, 0)];
        $gildedRose = new GildedRose($items);
        $gildedRose->updateQuality();
        $this->assertEquals(-1, $items[0]->sell_in);
        $this->assertEquals(0, $items[0]->quality);
    }

    public function testOrdinaryProductDecrementSellInAndQuality(): void
    {
        $items = [new Item('Ordinary product', 1, 1)];
        $gildedRose = new GildedRose($items);
        $gildedRose->updateQuality();
        $this->assertEquals(0, $items[0]->sell_in);
        $this->assertEquals(0, $items[0]->quality);
    }

    public function testOrdinaryProductDecrementSellInRegularAndQualityDoublyWhenSellInBelowZero(): void
    {
        $items = [new Item('Ordinary product', 0, 3)];
        $gildedRose = new GildedRose($items);
        $gildedRose->updateQuality();
        $this->assertEquals(-1, $items[0]->sell_in);
        $this->assertEquals(1, $items[0]->quality);
    }

    public function testAgedBrieQualityGrowsWhenSellInFalls(): void
    {
        $items = [new Item('Aged Brie', 1, 1)];
        $gildedRose = new GildedRose($items);
        $gildedRose->updateQuality();
        $this->assertEquals(0, $items[0]->sell_in);
        $this->assertEquals(2, $items[0]->quality);
    }

    public function testAgedBrieQualityGrowsDoublyWhenSellInFallsBelowZero(): void
    {
        $items = [new Item('Aged Brie', -1, 2)];
        $gildedRose = new GildedRose($items);
        $gildedRose->updateQuality();
        $this->assertEquals(-2, $items[0]->sell_in);
        $this->assertEquals(4, $items[0]->quality);
    }

    public function testSulfurasQualityAndSellInValuesDoNotChange(): void
    {
        $items = [new Item('Sulfuras, Hand of Ragnaros', 10, 80)];
        $gildedRose = new GildedRose($items);
        $gildedRose->updateQuality();
        $this->assertEquals(10, $items[0]->sell_in);
        $this->assertEquals(80, $items[0]->quality);
    }

    public function testSulfurasQualitySetToEightyItsNotEighty(): void
    {
        $items = [new Item('Sulfuras, Hand of Ragnaros', -1, 5)];
        $gildedRose = new GildedRose($items);
        $gildedRose->updateQuality();
        $this->assertEquals(-1, $items[0]->sell_in);
        $this->assertEquals(80, $items[0]->quality);
    }

    public function testBackstagePassesQualityGrowWhenSellInFall(): void
    {
        $items = [new Item('Backstage passes to a TAFKAL80ETC concert', 20, 5)];
        $gildedRose = new GildedRose($items);
        $gildedRose->updateQuality();
        $this->assertEquals(19, $items[0]->sell_in);
        $this->assertEquals(6, $items[0]->quality);
    }

    public function testBackstagePassesQualityGrowByTwoWhenSellInFallBetweenSixAndTen(): void
    {
        $items = [new Item('Backstage passes to a TAFKAL80ETC concert', 10, 1)];
        $gildedRose = new GildedRose($items);
        for ($i = 10, $j = 1; $i >= 6; $i--, $j+=2) {
            $gildedRose->updateQuality();
            $this->assertEquals($i-1, $items[0]->sell_in);
            $this->assertEquals($j+2, $items[0]->quality);
        }
    }

    public function testBackstagePassesQualityGrowByThreeWhenSellInFallBetweenFiveAndOne(): void
    {
        $items = [new Item('Backstage passes to a TAFKAL80ETC concert', 5, 1)];
        $gildedRose = new GildedRose($items);
        for ($i = 5, $j = 1; $i > 0; $i--, $j+=3) {
            $gildedRose->updateQuality();
            $this->assertEquals($i-1, $items[0]->sell_in);
            $this->assertEquals($j+3, $items[0]->quality);
        }
    }

    public function testBackstagePassesQualityFallToZeroAfterConcert(): void
    {
        for ($i = 0; $i > -1; $i--) {
            $items = [new Item('Backstage passes to a TAFKAL80ETC concert', $i, 5)];
            $gildedRose = new GildedRose($items);
            $gildedRose->updateQuality();
            $this->assertEquals($i-1, $items[0]->sell_in);
            $this->assertEquals(0, $items[0]->quality);
        }
    }
}
