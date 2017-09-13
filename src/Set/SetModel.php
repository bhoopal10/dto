<?php

namespace Fnp\Dto\Set;

use Fnp\Dto\Common\Helper\DtoHelper;
use Illuminate\Support\Str;

class SetModel
{
    protected $selected;
    protected $properties;

    public static function make($selected)
    {
        $object = new static($selected);

        return $object;
    }

    public function __construct($selected)
    {
        $this->selected   = $selected;
        $this->properties = $this->buildProperties($selected);
    }

    public static function __callStatic($name, $arguments)
    {
        $constant  = strtoupper(Str::snake($name));
        $constants = self::constants();

        return $constants[ $constant ];
    }

    public function property($property)
    {
        if (!isset($this->properties[ $property ])) {
            return NULL;
        }

        return $this->properties[ $property ];
    }

    public function properties()
    {
        return $this->properties;
    }

    public function __get($property)
    {
        return $this->property($property);
    }

    public static function has($handle)
    {
        $constants = self::constants();

        return in_array($handle, array_values($constants));
    }

    public static function all()
    {
        $constants = self::constants();

        $constants = array_map(function ($value) {
            return new static($value);
        }, $constants);

        return $constants;
    }

    /**
     * @param $pluckValue
     *
     * @return \Generator|array
     */
    public static function pluck($pluckValue)
    {
        /** @var SetModel $map */
        foreach (static::all() as $map) {
            yield $map->value() => $map->property($pluckValue);
        }
    }

    public static function constants()
    {
        $reflection = new \ReflectionClass(get_called_class());
        $constants  = $reflection->getConstants();

        return $constants;
    }

    protected function buildProperties($selected)
    {
        $constants  = self::constants();
        $handles    = array_flip($constants);
        $constant   = $handles[ $selected ];
        $getter     = DtoHelper::methodName('get', $constant, 'Properties');
        $properties = [];

        if (method_exists($this, 'getProperties')) {
            $allProperties = $this->getProperties();
            if (isset($allProperties[ $selected ])) {
                $properties = $allProperties[ $selected ];
            }
        }

        if (method_exists($this, $getter)) {
            $properties = $this->$getter();
        }

        return $properties;
    }

    public function value()
    {
        return $this->selected;
    }
}