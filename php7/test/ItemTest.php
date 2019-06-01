<?php

namespace Test;

use App\Item;
use PHPUnit\Framework\TestCase;

class ItemTest extends TestCase
{
    public function testItemSetPublicValues(): void
    {
        $item = new Item('product', 5, 6);

        $this->assertEquals('product', $item->name);
        $this->assertEquals(5, $item->sell_in);
        $this->assertEquals(6, $item->quality);
    }

    public function testItemReturnExpectedFormatWhenTreatedAsString(): void
    {
        $item = new Item('product', 5, 6);

        $this->assertEquals('product, 5, 6', (string) $item);
    }
}
