<?php

namespace Fnp\Dto;

use Fnp\Dto\Exception\DtoClassNotExistsException;
use Illuminate\Support\Collection;

class DtoCollectionFactory
{
    public static function make($dtoClass, $collection)
    {
        if (!$collection || !$dtoClass) {
            return NULL;
        }

        if (!class_exists($dtoClass, TRUE)) {
            throw new DtoClassNotExistsException(
                sprintf('Dto class %s not exists', $dtoClass)
            );
        }

        if (!$collection instanceof Collection) {
            $collection = new Collection($collection);
        }

        $collection = $collection->map(function ($item, $key) use ($dtoClass) {
            /** @var DtoModel $dtoClass */
            return $dtoClass::make($item);
        });

        return $collection;
    }
}