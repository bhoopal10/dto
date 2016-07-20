<?php

namespace Fnp\Dto\Collection;

use Fnp\Dto\Exception\DtoClassNotExistsException;
use Fnp\Dto\Flex\DtoModel;
use Illuminate\Support\Collection;

/**
 * DTO Collection Factory Class
 *
 * @package Fnp\Dto
 */
class DtoCollectionFactory
{
    /**
     * Converts existing collection to use models of a given class
     * or creates a new one.
     *
     * @param string $dtoClass
     * @param Collection|array|mixed $collection
     *
     * @return Collection|null
     * @throws DtoClassNotExistsException
     */
    public static function make($dtoClass, $collection)
    {
        if (!$collection) {
            $collection = [];
        }

        if (!$dtoClass || !class_exists($dtoClass, TRUE)) {
            throw DtoClassNotExistsException::make($dtoClass);
        }

        if ($collection instanceof \stdClass) {
            $collection = get_class_vars($collection);
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