<?php

namespace Fnp\Dto\Mapper;

use Fnp\Dto\Common\ToArray;
use Fnp\Dto\Flex\DtoModel;

class MapperModel extends DtoModel
{
    use ToArray;

    public function populateItems($items)
    {
        if ($items instanceof DtoModel) {
            $items = $items->toArray();
        }

        if ($items instanceof \stdClass) {
            $items = get_object_vars($items);
        }

        $reflection = new \ReflectionClass($this);
        $vars       = $reflection->getProperties();

        foreach ($vars as $var) {
            $var       = $var->getName();
            $targetVar = $this->$var;

            if (isset($items[ $targetVar ])) {
                $value  = $items[ $targetVar ];
                $setter = $this->methodExists('set', $var);

                if ($setter) {
                    $this->$setter($value);
                    continue;
                }

                $this->$var = $value;
                continue;
            }

            $this->$var = NULL;
        }
    }
}