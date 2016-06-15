<?php

namespace Fnp\Dto\Common;

trait ToJson
{
    abstract function toArray();
    
    /**
     * @inheritdoc
     *
     * @param int $options
     *
     * @return string
     */
    public function toJson($options = 0)
    {
        return json_encode($this->toArray(), $options);
    }
}