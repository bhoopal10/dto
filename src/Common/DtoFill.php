<?php

namespace Fnp\Dto\Common;

use Fnp\Dto\Common\Helper\DtoHelper;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

trait DtoFill
{
    /**
     * Populate items
     *
     * @param array $items
     *
     * @return mixed|void
     */
    public function fill($items)
    {
        if (!Arr::accessible($items) && $items instanceof Arrayable) {
            $items = $items->toArray();
        }

        if ($items instanceof \stdClass) {
            $items = get_object_vars($items);
        }

        $reflection = new \ReflectionClass($this);
        $vars       = $reflection->getProperties();

        foreach ($vars as $var) {
            $var   = $var->getName();
            $value = Arr::get($items, $var);

            if (!$value) {
                $snakeVersion = DtoHelper::snake($var);
                $value        = Arr::get($items, $snakeVersion);
            }

            if (!$value) {
                $camelVersion = DtoHelper::camel($var);
                $value        = Arr::get($items, $camelVersion);
            }

            if ($value) {
                $setter = DtoHelper::methodExists($this, 'fill', $var);

                if ($setter) {
                    $value = $this->$setter($value);

                    if ($value) {
                        $this->$var = $value;
                    }
                } else {
                    $this->$var = $value;
                }
            }
        }
    }
}