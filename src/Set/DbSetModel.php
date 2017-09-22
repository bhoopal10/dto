<?php

namespace Fnp\Dto\Set;

class DbSetModel extends SetModel
{
    protected function build($handle)
    {
        $constants  = self::constants();
        $handles    = array_flip($constants);
        $constant   = $handles[ $handle ];
    }
}