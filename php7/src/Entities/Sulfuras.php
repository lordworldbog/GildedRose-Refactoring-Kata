<?php

namespace App\Entities;

use App\Item;

class Sulfuras extends AbstractProduct
{
    public function __construct(Item $item)
    {
        parent::__construct($item);

        if ($item->quality !== 80) {
            $this->item->quality = 80;
        }
    }

    public function updateSellIn(): void
    {
        // never has to be sold
    }

    public function updateQuality(): void
    {
        // never has to be decreases in Quality
    }
}
