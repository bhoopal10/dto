<?php

namespace Fnp\Dto;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class DtoModel implements DtoModelInterface
{
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
            return DtoCollectionFactory::make(get_called_class(), $items);
        }

        $instance = new static;
        $instance->populateItems($items);

        return $instance;
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
                $getter = $this->methodExists('get', $var);

                if ($getter) {
                    $array [$var] = $this->$getter();
                } else {
                    $array[$var] = $this->$var;
                }
            }
        }

        return $array;
    }

    /**
     * Checks if method exists in the current model.
     * Returns method name if it does or NULL otherwise.
     *
     * @param string $type
     * @param string $name
     *
     * @return null|string
     */
    private function methodExists($type, $name)
    {
        $method = $type . ucfirst(Str::camel($name));

        return method_exists($this, $method) ? $method : NULL;
    }

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