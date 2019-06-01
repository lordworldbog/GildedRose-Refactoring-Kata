<?php

namespace Test\Entities;

use App\Entities\BackstagePasses;
use App\Item;
use PHPUnit\Framework\TestCase;
use RuntimeException;

class BackstagePassesTest extends TestCase
{
    public function testBackstagePasses_DecrementsSellIn(): void
    {
        $item = new Item('Backstage passes to a TAFKAL80ETC concert', 3, 1);
        $product = new BackstagePasses($item);
        $product->updateSellIn();
        $this->assertEquals(2, $item->sell_in);
    }

    public function testBackstagePasses_IncrementsQuality_WhenSellInGreaterThanTen(): void
    {
        $item = new Item('Backstage passes to a TAFKAL80ETC concert', 11, 1);
        $product = new BackstagePasses($item);
        $product->updateQuality();
        $this->assertEquals(2, $item->quality);
    }

    public function testBackstagePasses_IncrementsQualityDoubly_WhenSellInBetweenTenAndSix(): void
    {
        for ($i = 10; $i > 5; $i--) {
            $item = new Item('Backstage passes to a TAFKAL80ETC concert', $i, 1);
            $product = new BackstagePasses($item);
            $product->updateQuality();
            $this->assertEquals(3, $item->quality);
        }
    }

    public function testBackstagePasses_IncrementsQualityTriply_WhenSellInBetweenFiveAndOne(): void
    {
        for ($i = 5; $i > 0; $i--) {
            $item = new Item('Backstage passes to a TAFKAL80ETC concert', $i, 1);
            $product = new BackstagePasses($item);
            $product->updateQuality();
            $this->assertEquals(4, $item->quality);
        }
    }

    public function testBackstagePasses_QualityFallToZero_WhenSellInEqualZero(): void
    {
        $item = new Item('Backstage passes to a TAFKAL80ETC concert', 0, 10);
        $product = new BackstagePasses($item);
        $product->updateQuality();
        $this->assertEquals(0, $item->quality);
    }

    public function testBackstagePasses_QualityFallToZero_WhenSellInLowerZero(): void
    {
        $item = new Item('Backstage passes to a TAFKAL80ETC concert', -1, 10);
        $product = new BackstagePasses($item);
        $product->updateQuality();
        $this->assertEquals(0, $item->quality);
    }

    public function testBackstagePasses_CantIncrementQualityGreaterThanFifty(): void
    {
        $items = [
            new Item('Backstage passes to a TAFKAL80ETC concert', 11, 50),
            new Item('Backstage passes to a TAFKAL80ETC concert', 7, 49),
            new Item('Backstage passes to a TAFKAL80ETC concert', 7, 50),
            new Item('Backstage passes to a TAFKAL80ETC concert', 3, 48),
            new Item('Backstage passes to a TAFKAL80ETC concert', 3, 49),
            new Item('Backstage passes to a TAFKAL80ETC concert', 3, 50)
        ];

        foreach ($items as $item) {
            $product = new BackstagePasses($item);
            $product->updateQuality();
            $this->assertEquals(50, $item->quality);
        }
    }

    public function testBackstagePasses_CantBeCreated_WhenQualityGreaterThanFifty(): void
    {
        $this->expectException(RuntimeException::class);
        $item = new Item('Backstage passes to a TAFKAL80ETC concert', 2, 55);
        new BackstagePasses($item);
    }

    public function testBackstagePasses_CantBeCreated_WhenQualityLowerThanZero(): void
    {
        $this->expectException(RuntimeException::class);
        $item = new Item('Backstage passes to a TAFKAL80ETC concert', 2, -1);
        new BackstagePasses($item);
    }

    //TODO sellIn <= 0 and quality > 0 should throw exception?
}
