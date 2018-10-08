<?php

namespace Fnp\Dto\Common;

trait DtoProperties
{
    /**
     * Returns a list of properties
     *
     * @return \ReflectionProperty[]|void
     */
    public static function properties()
    {
        try {
            $reflection = new \ReflectionClass(get_called_class());
        } catch (\ReflectionException $e) {
            return;
        }

        return $reflection->getProperties();
    }
}