<?php

namespace App\Entities;

use App\Interfaces\ProductInterface;
use App\Item;

abstract class AbstractProduct implements ProductInterface
{
    protected $item;

    public function __construct(Item $item)
    {
        $this->item = $item;
    }

    public function __get($name)
    {
        return $this->item->$name;
    }

    public function __set($name, $value)
    {
        $this->item->$name = $value;
    }

    public function __isset($name)
    {
        return isset($this->item->$name);
    }
}
