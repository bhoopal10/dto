<?php

namespace Fnp\Dto\Common\Helper;

class InstanceOfThe
{
    public static function arrayable($object)
    {
        if (!is_object($object)) {
            return FALSE;
        }

        return method_exists($object, 'toArray');
    }
}