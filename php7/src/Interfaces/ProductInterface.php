<?php

namespace App\Interfaces;

interface ProductInterface
{
    public function updateSellIn(): void;

    public function updateQuality(): void;

    public function updateAttributes(): void;
}
