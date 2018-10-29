<?php

namespace Fnp\Dto\Mapper;

use Fnp\Dto\Common\DtoMapperFill;
use Fnp\Dto\Common\DtoToArray;
use Fnp\Dto\Flex\DtoModel;

class MapperModel extends DtoModel
{
    use DtoToArray;
    use DtoMapperFill;
}