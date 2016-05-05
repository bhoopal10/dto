<?php

namespace Fnp\Dto;

use Illuminate\Contracts\Support\Arrayable;

class BasicDtoModel implements DtoModelInterface
{
    /**
     * @inheritdoc
     *
     * @return array
     */
    public function toArray()
    {
        $vars = array_keys(
            get_class_vars(get_called_class())
        );

        $array = [];

        foreach ($vars as $var) {
            if ($this->$var instanceof Arrayable) {
                $array[$var] = $this->$var->toArray();
            } else {
                $array[$var] = $this->$var;
            }
        }

        return $array;
    }
}