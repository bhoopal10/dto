<?php

namespace Fnp\Dto\Mapper;

use Fnp\Dto\Common\DtoMapperFill;
use Fnp\Dto\Common\DtoToArray;
use Fnp\Dto\Flex\DtoModel;
use Illuminate\Contracts\Support\Arrayable;

class MapperModel extends DtoModel implements Arrayable
{
    use DtoToArray;
    use DtoMapperFill;
}