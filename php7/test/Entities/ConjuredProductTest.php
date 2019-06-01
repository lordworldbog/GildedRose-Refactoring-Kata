<?php

namespace Test\Entities;

use App\Entities\Conjured;
use App\Item;
use PHPUnit\Framework\TestCase;
use RuntimeException;

class ConjuredProductTest extends TestCase
{
    public function testConjuredProduct_DecrementsSellIn(): void
    {
        $item = new Item('Conjured Mana Cake', 3, 1);
        $product = new Conjured($item);
        $product->updateSellIn();
        $this->assertEquals(2, $item->sell_in);
    }

    public function testConjuredProduct_DecrementsQualityDoubly_WhenSellInGreaterThanZero(): void
    {
        $item = new Item('Conjured Mana Cake', 1, 2);
        $product = new Conjured($item);
        $product->updateQuality();
        $this->assertEquals(0, $item->quality);
    }

    public function testConjuredProduct_DecrementsQualityQuarterly_WhenSellInEqualZero(): void
    {
        $item = new Item('Conjured Mana Cake', 0, 4);
        $product = new Conjured($item);
        $product->updateQuality();
        $this->assertEquals(0, $item->quality);
    }

    public function testConjuredProduct_DecrementsQualityQuarterly_WhenSellInLowerThanZero(): void
    {
        $item = new Item('Conjured Mana Cake', -1, 4);
        $product = new Conjured($item);
        $product->updateQuality();
        $this->assertEquals(0, $item->quality);
    }

    public function testBackstagePasses_CantDecrementQualityLowerThanZero(): void
    {
        $items = [
            new Item('Conjured Mana Cake', 1, 1),
            new Item('Conjured Mana Cake', 1, 0),
            new Item('Conjured Mana Cake', 0, 3),
            new Item('Conjured Mana Cake', 0, 2),
            new Item('Conjured Mana Cake', 0, 1),
            new Item('Conjured Mana Cake', 0, 0),
        ];

        foreach ($items as $item) {
            $product = new Conjured($item);
            $product->updateQuality();
            $this->assertEquals(0, $item->quality);
        }
    }

    public function testConjuredProduct_CantBeCreated_WhenQualityGreaterThanFifty(): void
    {
        $this->expectException(RuntimeException::class);
        $item = new Item('Conjured Mana Cake', 2, 55);
        new Conjured($item);
    }

    public function testConjuredProduct_CantBeCreated_WhenQualityLowerThanZero(): void
    {
        $this->expectException(RuntimeException::class);
        $item = new Item('Conjured Mana Cake', 2, -1);
        new Conjured($item);
    }
}
