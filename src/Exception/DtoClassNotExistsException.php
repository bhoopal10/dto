<?php

namespace Fnp\Dto\Exception;

class DtoClassNotExistsException extends DtoException
{
    public static function make($dtoClassName)
    {
        return new self(
            sprintf('Dto class %s not exists', $dtoClassName)
        );
    }
}