<?php

namespace Fnp\Dto\Set;

class DbSetModel extends SetModel
{
    protected function buildProperties($selected)
    {
        $constants  = self::constants();
        $handles    = array_flip($constants);
        $constant   = $handles[ $selected ];
    }
}