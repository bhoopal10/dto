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

            if (is_null($value)) {
                $snakeVersion = DtoHelper::snake($var);
                $value        = Arr::get($items, $snakeVersion);
            }

            if (is_null($value)) {
                $camelVersion = DtoHelper::camel($var);
                $value        = Arr::get($items, $camelVersion);
            }

            if (!is_null($value)) {
                $setter = DtoHelper::methodExists($this, 'fill', $var);

                if ($setter) {
                    $value = $this->$setter($value);

                    if (!is_null($value)) {
                        $this->$var = $value;
                    }
                } else {
                    $this->$var = $value;
                }
            }
        }
    }
}