<?php

namespace Fnp\Dto\Flex;

use Fnp\Dto\Collection\DtoCollectionFactory;
use Fnp\Dto\Common\DtoFill;
use Fnp\Dto\Common\DtoToArray;
use Fnp\Dto\Common\DtoToJson;
use Fnp\Dto\Contract\DtoModelContract;
use Fnp\Dto\Exception;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Support\Collection;

abstract class DtoModel implements DtoModelContract, Jsonable
{
    use DtoToArray;
    use DtoToJson;
    use DtoFill;
    
    /**
     * Make model with initial data
     *
     * @param $items
     *
     * @return $this
     */
    public static function make($items)
    {
        $instance = new static;

        $instance->fill($items);

        return $instance;
    }

    /**
     * Make model collection with initial data
     *
     * @param $items
     *
     * @return Collection|null
     * @throws Exception\DtoClassNotExistsException
     */
    public static function collection($items)
    {
        return DtoCollectionFactory::make(get_called_class(), $items);
    }
}