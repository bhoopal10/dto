<?php

namespace Fnp\Dto\Common\Helper;

class DtoHelper
{
    /**
     * The cache of snake-cased words.
     *
     * @var array
     */
    protected static $snakeCache = [];
    /**
     * The cache of camel-cased words.
     *
     * @var array
     */
    protected static $camelCache = [];
    /**
     * The cache of studly-cased words.
     *
     * @var array
     */
    protected static $studlyCache = [];

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
    public static function methodExists($object, $prefix, $name, $suffix = NULL)
    {
        $method = static::methodName($prefix, $name, $suffix);

        return method_exists($object, $method) ? $method : NULL;
    }

    /**
     * Builds a method name based on prefix, name and suffix
     *
     * @param string $prefix
     * @param string $name
     * @param string $suffix
     *
     * @return string
     */
    public static function methodName($prefix, $name, $suffix = NULL)
    {
        $name = str_replace([' ', '-', '.'], '_', $name);

        if (static::contains($name, '_') || static::isAllCaps($name)) {
            $name = strtolower($name);
        }

        $elPrefix = $prefix;
        $elName   = ucfirst(static::camel($name));
        $elSuffix = $suffix;

        if (empty($prefix)) {
            $elPrefix = NULL;
            $elName   = static::camel($name);
        }

        if ($suffix) {
            $elSuffix = ucFirst($suffix);
        }

        $method = $elPrefix . $elName . $elSuffix;

        return $method;
    }

    /**
     * Determine if a given string contains a given substring.
     *
     * @param  string       $haystack
     * @param  string|array $needles
     *
     * @return bool
     */
    public static function contains($haystack, $needles)
    {
        foreach ((array)$needles as $needle) {
            if ($needle !== '' && mb_strpos($haystack, $needle) !== FALSE) {
                return TRUE;
            }
        }

        return FALSE;
    }

    public static function isAllCaps($value)
    {
        return strtoupper($value) == $value;
    }

    public static function camel($value)
    {
        if (isset(static::$camelCache[ $value ])) {
            return static::$camelCache[ $value ];
        }

        $camel = str_replace([' ', '-', '.'], '_', $value);

        if (static::isAllCaps($camel)) {
            $camel = strtolower($camel);
        }

        return static::$camelCache[ $value ] = lcfirst(static::studly($camel));
    }

    /**
     * Convert a value to studly caps case.
     *
     * @param  string $value
     *
     * @return string
     */
    public static function studly($value)
    {
        $key = $value;
        if (isset(static::$studlyCache[ $key ])) {
            return static::$studlyCache[ $key ];
        }
        $value = ucwords(str_replace(['-', '_'], ' ', $value));

        return static::$studlyCache[ $key ] = str_replace(' ', '', $value);
    }

    public static function snake($value, $delimiter = '_')
    {
        $key = $value;

        if (isset(static::$snakeCache[ $key ][ $delimiter ])) {
            return static::$snakeCache[ $key ][ $delimiter ];
        }

        $snake = str_replace([' ', '-', '.'], '_', $value);
        $snake = preg_replace('/(\d.*)/', '_$1', $snake);
        $snake = str_replace('__', '_', $snake);

        if (static::isAllCaps($snake)) {
            $snake = strtolower($snake);
        }

        if (!ctype_lower($snake)) {
            $snake = preg_replace('/\s+/u', '', ucwords($snake));
            $snake = static::lower(preg_replace('/(.)(?=[A-Z])/u', '$1' . $delimiter, $snake));
        }

        return static::$snakeCache[ $key ][ $delimiter ] = $snake;
    }

    /**
     * Convert the given string to lower-case.
     *
     * @param  string $value
     *
     * @return string
     */
    public static function lower($value)
    {
        return mb_strtolower($value, 'UTF-8');
    }

    /**
     * Generate a more truly "random" alpha-numeric string.
     *
     * @param  int $length
     *
     * @return string
     * @throws \Exception
     */
    public static function random($length = 16)
    {
        $string = '';
        while (($len = strlen($string)) < $length) {
            $size   = $length - $len;
            $bytes  = random_bytes($size);
            $string .= substr(str_replace(['/', '+', '='], '', base64_encode($bytes)), 0, $size);
        }

        return $string;
    }
}