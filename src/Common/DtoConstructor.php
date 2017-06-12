<?php

namespace Fnp\Dto\Common;

trait DtoConstructor
{
    public function __construct($items)
    {
        $this->fill($items);
    }

    abstract function fill($items);
}