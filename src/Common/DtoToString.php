<?php

namespace Fnp\Dto\Common;

trait DtoToString
{
    abstract public function toJson($options = 0);

    public function __toString()
    {
        return $this->toJson();
    }
}