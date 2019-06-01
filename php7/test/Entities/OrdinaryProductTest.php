<?php

namespace Test\Entities;

use App\Entities\OrdinaryProduct;
use App\Item;
use PHPUnit\Framework\TestCase;
use RuntimeException;

class OrdinaryProductTest extends TestCase
{
    public function testOrdinaryProduct_DecrementsSellIn(): void
    {
        $item = new Item('ordinary', 3, 1);
        $product = new OrdinaryProduct($item);
        $product->updateSellIn();
        $this->assertEquals(2, $item->sell_in);
    }

    public function testOrdinaryProduct_DecrementsQuality_WhenSellInGreaterThanZero(): void
    {
        $item = new Item('ordinary', 3, 1);
        $product = new OrdinaryProduct($item);
        $product->updateQuality();
        $this->assertEquals(0, $item->quality);
    }

    public function testOrdinaryProduct_DecrementsQualityDoubly_WhenSellInEqualZero(): void
    {
        $item = new Item('ordinary', 0, 2);
        $product = new OrdinaryProduct($item);
        $product->updateQuality();
        $this->assertEquals(0, $item->quality);
    }

    public function testOrdinaryProduct_DecrementsQualityDoubly_WhenSellInLowerThanZero(): void
    {
        $item = new Item('ordinary', -1, 2);
        $product = new OrdinaryProduct($item);
        $product->updateQuality();
        $this->assertEquals(0, $item->quality);
    }

    public function testOrdinaryProduct_CantDecrementQualityLowerThanZero_WhenSellInGreaterThanZero(): void
    {
        $item = new Item('ordinary', 3, 0);
        $product = new OrdinaryProduct($item);
        $product->updateQuality();
        $this->assertEquals(0, $item->quality);
    }

    public function testOrdinaryProduct_CantDecrementQualityLowerThanZero_WhenSellInEqualZero(): void
    {
        $item = new Item('ordinary', 0, 0);
        $product = new OrdinaryProduct($item);
        $product->updateQuality();
        $this->assertEquals(0, $item->quality);
    }

    public function testOrdinaryProduct_CantDecrementQualityLowerThanZero_WhenSellInLowerThanZero(): void
    {
        $item = new Item('ordinary', -1, 0);
        $product = new OrdinaryProduct($item);
        $product->updateQuality();
        $this->assertEquals(0, $item->quality);
    }

    public function testOrdinaryProduct_DecrementQualityPartly_WhenSellInLowerThanZeroAndQualityEqualOne(): void
    {
        $item = new Item('ordinary', -1, 1);
        $product = new OrdinaryProduct($item);
        $product->updateQuality();
        $this->assertEquals(0, $item->quality);
    }

    public function testOrdinaryProduct_CantBeCreated_WhenQualityGreaterThanFifty(): void
    {
        $this->expectException(RuntimeException::class);
        $item = new Item('ordinary', 2, 55);
        new OrdinaryProduct($item);
    }

    public function testOrdinaryProduct_CantBeCreated_WhenQualityLowerThanZero(): void
    {
        $this->expectException(RuntimeException::class);
        $item = new Item('ordinary', 2, -1);
        new OrdinaryProduct($item);
    }
}
