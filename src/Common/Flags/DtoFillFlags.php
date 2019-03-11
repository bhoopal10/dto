<?php

namespace Fnp\Dto\Common\Flags;

use Fnp\Dto\Flag\FlagModel;
use ReflectionProperty;

class DtoFillFlags extends FlagModel
{
    const FILL_PUBLIC       = 0b0000001; // Fill only public properties
    const FILL_PROTECTED    = 0b0000010; // Fill only protected properties
    const FILL_PRIVATE      = 0b0000100; // Fill only private properties
    const STRICT_PROPERTIES = 0b0001000; // Strict property matching (no Camel <=> Snake)

    /**
     * Reflection options based on the flags
     *
     * @return int|mixed
     */
    public function reflectionOptions()
    {
        $options = 0;

        if ($this->has(self::FILL_PUBLIC))
            $options += ReflectionProperty::IS_PUBLIC;

        if ($this->has(self::FILL_PROTECTED))
            $options += ReflectionProperty::IS_PROTECTED;

        if ($this->has(self::FILL_PRIVATE))
            $options += ReflectionProperty::IS_PRIVATE;

        if ($options < 1)
            $options = ReflectionProperty::IS_PUBLIC +
                       ReflectionProperty::IS_PROTECTED +
                       ReflectionProperty::IS_PRIVATE;

        return $options;
    }

    /**
     * Should the property matching be string, meaining
     * no Camel Case <=> Snake Case conversion.
     *
     * @return bool
     */
    public function strictProperties()
    {
        return $this->has(self::STRICT_PROPERTIES);
    }
}