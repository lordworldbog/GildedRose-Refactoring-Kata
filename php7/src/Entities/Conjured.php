<?php

namespace App\Entities;

use App\Item;
use RuntimeException;

class Conjured extends AbstractProduct
{
    public function __construct(Item $item)
    {
        parent::__construct($item);

        if ($item->quality > 50 || $item->quality < 0) {
            $message = Item::class . "with name '$item->name' cant have quality greater than 50 and lower than 0";
            throw new RuntimeException($message);
        }
    }

    public function updateSellIn(): void
    {
        --$this->item->sell_in;
    }

    public function updateQuality(): void
    {
        $tmpQuality = $this->item->quality;

        if ($this->item->sell_in <= 0) {
            $tmpQuality -=4;
        }

        if ($this->item->sell_in > 0) {
            $tmpQuality -=2;
        }

        $this->item->quality = $tmpQuality >  0 ? $tmpQuality : 0;
    }
}
