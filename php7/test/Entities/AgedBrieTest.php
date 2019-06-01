<?php

namespace Test\Entities;

use App\Entities\AgedBrie;
use App\Item;
use PHPUnit\Framework\TestCase;
use RuntimeException;

class AgedBrieTest extends TestCase
{
    public function testAgedBrie_DecrementsSellIn(): void
    {
        $item = new Item('Aged Brie', 3, 1);
        $product = new AgedBrie($item);
        $product->updateSellIn();
        $this->assertEquals(2, $item->sell_in);
    }

    public function testAgedBrie_IncrementsQuality_WhenSellInGreaterThanZero(): void
    {
        $item = new Item('Aged Brie', 1, 1);
        $product = new AgedBrie($item);
        $product->updateQuality();
        $this->assertEquals(2, $item->quality);
    }

    public function testAgedBrie_IncrementsQualityDoubly_WhenSellInEqualZero(): void
    {
        $item = new Item('Aged Brie', 0, 1);
        $product = new AgedBrie($item);
        $product->updateQuality();
        $this->assertEquals(3, $item->quality);
    }

    public function testAgedBrie_IncrementsQualityDoubly_WhenSellInLowerThanZero(): void
    {
        $item = new Item('Aged Brie', -1, 1);
        $product = new AgedBrie($item);
        $product->updateQuality();
        $this->assertEquals(3, $item->quality);
    }

    public function testAgedBrie_CantIncrementQualityGreaterThenFifty_WhenSellInGreaterThanZero(): void
    {
        $item = new Item('Aged Brie', 2, 50);
        $product = new AgedBrie($item);
        $product->updateQuality();
        $this->assertEquals(50, $item->quality);
    }

    public function testAgedBrie_CantIncrementQualityGreaterThenFifty_WhenSellInEqualZero(): void
    {
        $item = new Item('Aged Brie', 0, 50);
        $product = new AgedBrie($item);
        $product->updateQuality();
        $this->assertEquals(50, $item->quality);
    }

    public function testAgedBrie_CantIncrementQualityGreaterThenFifty_WhenSellInLowerThanZero(): void
    {
        $item = new Item('Aged Brie', -1, 50);
        $product = new AgedBrie($item);
        $product->updateQuality();
        $this->assertEquals(50, $item->quality);
    }

    public function testAgedBrie_IncrementQualityPartly_WhenSellInLowerThanZeroAndQualityEqualFortyNine(): void
    {
        $item = new Item('Aged Brie', -1, 49);
        $product = new AgedBrie($item);
        $product->updateQuality();
        $this->assertEquals(50, $item->quality);
    }

    public function testAgedBrie_CantBeCreated_WhenQualityGreaterThanFifty(): void
    {
        $this->expectException(RuntimeException::class);
        $item = new Item('Aged Brie', 2, 55);
        new AgedBrie($item);
    }

    public function testAgedBrie_CantBeCreated_WhenQualityLowerThanZero(): void
    {
        $this->expectException(RuntimeException::class);
        $item = new Item('Aged Brie', 2, -1);
        new AgedBrie($item);
    }
}
