<?php

namespace Fnp\Dto\Property;

/**
 * Allows direct read access to DTO properties
 *
 * @package Phoenix\Services\Transport
 */
trait PropertyReadAccess
{
    function __get($name)
    {
        $getter = 'get' . ucfirst(camel_case($name));

        if (method_exists($this, $getter)) {
            return $this->$getter();
        } else {
            return $this->$name;
        }
    }
}