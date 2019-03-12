<?php

namespace Fnp\Dto\Common\Flags;

use Fnp\Dto\Flag\FlagModel;
use ReflectionProperty;

class DtoToArrayFlags extends FlagModel
{
    const INCLUDE_PUBLIC             = 0b00000001; // Fill only public properties
    const INCLUDE_PROTECTED          = 0b00000010; // Fill only protected properties
    const INCLUDE_PRIVATE            = 0b00000100; // Fill only private properties
    const EXCLUDE_NULLS              = 0b00001000; // Exclude values with NULL
    const DONT_SERIALIZE_OBJECTS     = 0b00010000; // Do Not Serialize objects
    const SERIALIZE_STRING_PROVIDERS = 0b00100000; // Serialize objects with __toString
    const PREFER_STRING_PROVIDERS    = 0b01000000; // Prefer String Providers over Object Serialization

    /**
     * Reflection options based on the flags
     *
     * @return int|mixed
     */
    public function reflectionOptions()
    {
        $options = 0;

        if ($this->has(self::INCLUDE_PUBLIC))
            $options += ReflectionProperty::IS_PUBLIC;

        if ($this->has(self::INCLUDE_PROTECTED))
            $options += ReflectionProperty::IS_PROTECTED;

        if ($this->has(self::INCLUDE_PRIVATE))
            $options += ReflectionProperty::IS_PRIVATE;

        if ($options < 1)
            $options = ReflectionProperty::IS_PUBLIC +
                       ReflectionProperty::IS_PROTECTED;

        return $options;
    }

    public function serializeObjects()
    {
        return $this->not(self::DONT_SERIALIZE_OBJECTS);
    }

    public function serializeStringProviders()
    {
        return $this->has(self::SERIALIZE_STRING_PROVIDERS);
    }

    public function excludeNulls()
    {
        return $this->has(self::EXCLUDE_NULLS);
    }

    public function preferStringProviders()
    {
        return $this->has(self::PREFER_STRING_PROVIDERS);
    }
}