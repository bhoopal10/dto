<?php

namespace Fnp\Dto\Common;

use Fnp\Dto\Common\Helper\DtoHelper;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Arr;

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

        foreach ($vars as $variable) {

            $variable->setAccessible(TRUE);

            $varName  = $variable->getName();
            $varValue = Arr::get($items, $varName);

            if (is_null($varValue)) {
                $snakeVersion = DtoHelper::snake($varName);
                $varValue     = Arr::get($items, $snakeVersion);
            }

            if (is_null($varValue)) {
                $camelVersion = DtoHelper::camel($varName);
                $varValue     = Arr::get($items, $camelVersion);
            }

            if (!is_null($varValue)) {
                $setter = DtoHelper::methodExists($this, 'fill', $varName);

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