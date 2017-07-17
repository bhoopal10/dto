<?php

namespace Fnp\Dto\Common\Helper;

use Illuminate\Support\Str;

class DtoHelper
{
    /**
     * Checks if method exists in the current model.
     * Returns method name if it does or NULL otherwise.
     *
     * @param        $object
     * @param string $prefix
     * @param string $name
     * @param string $suffix
     *
     * @return null|string
     */
    public static function methodExists($object, $prefix = NULL, $name, $suffix = NULL)
    {
        $method = self::methodName($prefix, $name, $suffix);

        return method_exists($object, $method) ? $method : NULL;
    }

    /**
     * Builds a method name based on prefix, name and suffix
     *
     * @param null $prefix
     * @param      $name
     * @param null $suffix
     *
     * @return string
     */
    public static function methodName($prefix = NULL, $name, $suffix = NULL)
    {
        $name = str_replace([' ', '-', '.'], '_', $name);

        if (Str::contains($name, '_') || self::isAllCaps($name)) {
            $name = strtolower($name);
        }

        $elPrefix = $prefix;
        $elName   = ucfirst(Str::camel($name));
        $elSuffix = $suffix;

        if (empty($prefix)) {
            $elPrefix = NULL;
            $elName   = Str::camel($name);
        }

        if ($suffix) {
            $elSuffix = ucFirst($suffix);
        }

        $method = $elPrefix . $elName . $elSuffix;

        return $method;
    }

    public static function camel($value)
    {
        $camel = str_replace([' ', '-', '.'], '_', $value);

        if (strpos($camel, '_') && self::isAllCaps($camel)) {
            $camel = strtolower($camel);
        }

        $camel = Str::camel($camel);

        return $camel;
    }

    public static function snake($value)
    {
        $snake = str_replace([' ', '-', '.'], '_', $value);
        $snake = preg_replace('/(\d.*)/', '_$1', $snake);
        $snake = str_replace('__', '_', $snake);

        if (strpos($snake, '_') && self::isAllCaps($snake)) {
            $snake = strtolower($snake);
        }

        $snake = Str::snake($snake);

        return $snake;
    }

    public static function isAllCaps($value)
    {
        return strtoupper($value) == $value;
    }
}