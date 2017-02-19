<?php

namespace Fnp\Dto\Common;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Str;

trait DtoToArray
{
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
}