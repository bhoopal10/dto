<?php

namespace Fnp\Dto\Common;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Str;
use ReflectionProperty;

trait DtoToArray
{
    /**
     * @inheritdoc
     *
     * @return array
     */
    public function toArray()
    {
        $reflection = new \ReflectionClass($this);
        $vars       = $reflection->getProperties(
            ReflectionProperty::IS_PUBLIC | ReflectionProperty::IS_PROTECTED
        );

        $array = [];

        foreach ($vars as $var) {

            $var = $var->getName();

            if ($this->$var instanceof Arrayable) {
                $array[$var] = $this->$var->toArray();
            } else {
                $getter = $this->_methodExists('get', $var);

                if ($getter) {
                    $array[$var] = $this->$getter();
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
    private function _methodExists($type, $name)
    {
        $method = $type . ucfirst(Str::camel($name));

        return method_exists($this, $method) ? $method : NULL;
    }
}