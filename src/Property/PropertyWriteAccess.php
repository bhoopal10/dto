<?php

namespace Fnp\Dto\Property;

/**
 * Allows direct write access to DTO properties
 *
 * @package Phoenix\Services\Transport
 */
trait PropertyWriteAccess
{
    function __set($name, $value)
    {
        $this->populateItems([$name => $value]);
    }
}