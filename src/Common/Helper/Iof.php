<?php

namespace Fnp\Dto\Common\Helper;

/**
 * Class Iof (Instance Of)
 *
 * @package Fnp\Dto\Common\Helper
 */
class Iof
{
    public static function arrayable($object)
    {
        if (!is_object($object)) {
            return FALSE;
        }

        return method_exists($object, 'toArray');
    }
}