<?php

namespace Fnp\Dto\Flex;

use Fnp\Dto\Collection\DtoCollectionFactory;
use Fnp\Dto\Common\ToArray;
use Fnp\Dto\Common\ToJson;
use Fnp\Dto\Contract\DtoModelContract;
use Fnp\Dto\Exception;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class DtoModel implements DtoModelContract, Jsonable
{
    use ToArray, ToJson;
    
    /**
     * Make model with initial data
     *
     * @param $items
     *
     * @return $this|Collection
     */
    public static function make($items)
    {
        if ($items instanceof Collection) {
            return self::collection($items);
        }

        $instance = new static;
        $instance->populateItems($items);

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
    public function populateItems($items)
    {
        if ($items instanceof DtoModel) {
            $items = $items->toArray();
        }

        if ($items instanceof \stdClass) {
            $items = get_object_vars($items);
        }

        $reflection = new \ReflectionClass($this);
        $vars       = $reflection->getProperties();

        foreach ($vars as $var) {
            $var   = $var->getName();
            $value = NULL;
            $found = FALSE;

            if (isset($items[$var])) {
                $value = $items[$var];
                $found = TRUE;
            }

            if (!$found) {
                $snakeVersion = Str::snake($var);

                if (isset($items[$snakeVersion])) {
                    $value = $items[$snakeVersion];
                    $found = TRUE;
                }
            }

            if (!$found) {
                $camelVersion = Str::camel($var);

                if (isset($items[$camelVersion])) {
                    $value = $items[$camelVersion];
                    $found = TRUE;
                }
            }

            if ($found) {
                $setter = $this->methodExists('set', $var);

                if ($setter) {
                    $this->$setter($value);
                } else {
                    $this->$var = $value;
                }
            }
        }
    }
}