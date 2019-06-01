<?php

namespace App\Entities;

use App\Item;
use RuntimeException;

class AgedBrie extends AbstractProduct
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
        if ($this->item->sell_in <= 0 && $this->item->quality <= 48) {
            $this->item->quality += 2;
        } elseif ($this->item->quality <= 49) {
            ++$this->item->quality;
        }
    }
}
