<?php

namespace Fnp\Dto\Common;

use Fnp\Dto\Common\Helper\Iof;
use Fnp\Dto\Common\Helper\Obj;
use Fnp\Dto\Common\Helper\Str;
use Tightenco\Collect\Support\Arr;

trait DtoFill
{
    /**
     * Populate items
     *
     * @param array $items
     */
    public function fill($items)
    {
        if (is_null($items)) {
            return;
        }

        if (!Arr::accessible($items) && Iof::arrayable($items)) {
            $items = $items->toArray();
        }

        if ($items instanceof \stdClass) {
            $items = get_object_vars($items);
        }

        try {
            $reflection = new \ReflectionClass($this);
        } catch (\ReflectionException $e) {
            return;
        }

        $vars       = $reflection->getProperties();

        foreach ($vars as $variable) {

            $variable->setAccessible(TRUE);

            $varName  = $variable->getName();
            $varValue = Arr::get($items, $varName);

            if (is_null($varValue)) {
                $snakeVersion = Str::snake($varName);
                $varValue     = Arr::get($items, $snakeVersion);
            }

            if (is_null($varValue)) {
                $camelVersion = Str::camel($varName);
                $varValue     = Arr::get($items, $camelVersion);
            }

            if (!is_null($varValue)) {
                $setter = Obj::methodExists($this, 'fill', $varName);

                if ($setter) {
                    $varValue = $this->$setter($varValue);

                    if (!is_null($varValue)) {
                        $variable->setValue($this, $varValue);
                    }
                } else {
                    $variable->setValue($this, $varValue);
                }
            }
        }
    }
}