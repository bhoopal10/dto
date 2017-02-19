<?php

namespace Fnp\Dto\Map;

class DbMapModel extends MapModel
{
    protected function buildProperties($selected)
    {
        $constants  = self::constants();
        $handles    = array_flip($constants);
        $constant   = $handles[ $selected ];
    }

}