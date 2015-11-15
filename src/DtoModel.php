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
    static public function make($items)
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
        $reflection = new \ReflectionClass($this);
        $vars       = $reflection->getProperties();

        foreach ($vars as $var) {
            $var   = $var->getName();
            $value = NULL;

            if (isset( $items[ $var ] )) {
                $value = $items[ $var ];
            } else {
                $camelVersion = Str::camel($var);

                if (isset( $items[ $camelVersion ] )) {
                    $value = $items[ $camelVersion ];
                }

                $snakeVersion = snake_case($var);

                if (isset( $items[ $snakeVersion ] )) {
                    $value = $items[ $snakeVersion ];
                }
            }

            if ($value) {
                $setter = 'set' . ucfirst(Str::camel($var));

                if (method_exists($this, $setter)) {
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
                $array[ $var ] = $this->$var->toArray();
            } else {
                $getter = 'get' . ucfirst(Str::camel($var));

                if (method_exists($this, $getter)) {
                    $array [ $var ] = $this->$getter();
                } else {
                    $array[ $var ] = $this->$var;
                }
            }
        }

        return $array;
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