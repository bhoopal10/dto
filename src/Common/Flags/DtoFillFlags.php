<?php

namespace Fnp\Dto\Common\Flags;

use Fnp\Dto\Flag\FlagModel;

class DtoFillFlags extends FlagModel
{
    /*
     * Fill Certain Property Types
     */
    const FILL_PUBLIC    = \ReflectionProperty::IS_PUBLIC;
    const FILL_PROTECTED = \ReflectionProperty::IS_PROTECTED;
    const FILL_PRIVATE   = \ReflectionProperty::IS_PRIVATE;

    /*
     * Do not try to match Camel Case <=> Snake Case
     * when filling properties
     */
    const STRICT_PROPERTIES = 'spr';

    /**
     * Reflection options based on the flags
     *
     * @return int|mixed
     */
    public function reflectionOptions()
    {
        if ($this->none()) {
            return self::FILL_PUBLIC | self::FILL_PROTECTED | self::FILL_PRIVATE;
        }

        $flags   = $this->flags();
        $options = array_pop($flags);

        array_map(function ($flag) use (&$options) {

            if (!is_numeric($flag))
                return;

            $options = $options | $flag;

        }, $this->flags());

        return $options;
    }
}