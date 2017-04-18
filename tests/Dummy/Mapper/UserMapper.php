<?php

namespace Fnp\Dto\Test\Dummy\Mapper;

use Fnp\Dto\Common\DtoArrayAccess;
use Fnp\Dto\Common\DtoIteratorAggregate;
use Fnp\Dto\Mapper\MapperModel;

class UserMapper extends MapperModel implements \ArrayAccess
{
    use DtoArrayAccess;

    public $userName;
    public $email;
    public $name;
}