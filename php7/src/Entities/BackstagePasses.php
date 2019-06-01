<?php

namespace App\Entities;

use App\Item;
use RuntimeException;

class BackstagePasses extends AbstractProduct
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

        if ($this->item->sell_in <= 0 && $tmpQuality !== 0) {
            $tmpQuality = 0;
        }

        if ($this->item->sell_in > 10) {
            ++$tmpQuality;
        }

        if ($this->item->sell_in <= 10 && $this->item->sell_in > 5) {
            $tmpQuality += 2;
        }

        if ($this->item->sell_in <= 5 && $this->item->sell_in > 0) {
            $tmpQuality += 3;
        }

        $this->item->quality = $tmpQuality <  50 ? $tmpQuality : 50;
    }
}
