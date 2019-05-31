<?php

namespace App\Interfaces;

use App\Item;

interface ProductProviderInterface
{
    public function createProductInstanceFrom(Item $item): ProductInterface;
}
