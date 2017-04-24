<?php

namespace Fnp\Dto\Flex;

use Fnp\Dto\Collection\DtoCollectionFactory;
use Fnp\Dto\Common\DtoToArray;
use Fnp\Dto\Common\DtoToJson;
use Fnp\Dto\Contract\DtoModelContract;
use Fnp\Dto\Exception;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

abstract class DtoModel implements DtoModelContract, Jsonable
{
    use DtoToArray, DtoToJson;
    
    /**
     * Make model with initial data
     *
     * @param $items
     *
     * @return $this
     */
    public static function make($items)
    {
        $instance = new static;
        $instance->fill($items);

        return $instance;
    }

    /**
     * Make model collection with initial data
     *
     * @param $items
     *
     * @return Collection|null
     * @throws Exception\DtoClassNotExistsException
     */
    public static function collection($items)
    {
        return DtoCollectionFactory::make(get_called_class(), $items);
    }

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
                $snakeVersion = Str::snake($var);
                $value        = Arr::get($items, $snakeVersion);
            }

            if (!$value) {
                $camelVersion = Str::camel($var);
                $value        = Arr::get($items, $camelVersion);
            }

            if ($value) {
                $setter = $this->_methodExists('set', $var);

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