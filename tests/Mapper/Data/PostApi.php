<?php

namespace Fnp\Dto\Test\Mapper\Data;

use Fnp\Dto\Mapper\MapperModel;

class PostApi extends MapperModel
{
    public $header      = 'title';
    public $body        = 'body';
    public $authorName  = 'author.name';
    public $authorEmail = 'author.email';
}