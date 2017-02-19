<?php

namespace Fnp\Dto\Common;

use Illuminate\Support\Collection;

trait DtoToCollection
{
    abstract public function toArray();

    public function toCollection()
    {
        return new Collection($this->toArray());
    }
}