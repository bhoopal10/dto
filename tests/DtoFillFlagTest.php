<?php

use Fnp\Dto\Common\Flags\DtoFillFlags;

class DtoFillFlagTest extends \PHPUnit\Framework\TestCase
{
    public function data()
    {
        return [
            'All'=>[
                DtoFillFlags::make(),
                ReflectionProperty::IS_PRIVATE + ReflectionProperty::IS_PROTECTED + ReflectionProperty::IS_PUBLIC,
            ],
            'Public Only'=>[
                DtoFillFlags::make(DtoFillFlags::FILL_PUBLIC),
                ReflectionProperty::IS_PUBLIC,
            ],
            'Protected Only'=>[
                DtoFillFlags::make(DtoFillFlags::FILL_PROTECTED),
                ReflectionProperty::IS_PROTECTED,
            ],
            'Private Only'=>[
                DtoFillFlags::make(DtoFillFlags::FILL_PRIVATE),
                ReflectionProperty::IS_PRIVATE,
            ],
            'Public & Protected'=>[
                DtoFillFlags::make(DtoFillFlags::FILL_PUBLIC + DtoFillFlags::FILL_PROTECTED),
                ReflectionProperty::IS_PUBLIC + ReflectionProperty::IS_PROTECTED,
            ],
            'Public & Private'=>[
                DtoFillFlags::make([DtoFillFlags::FILL_PUBLIC,DtoFillFlags::FILL_PRIVATE]),
                ReflectionProperty::IS_PUBLIC + ReflectionProperty::IS_PRIVATE,
            ],
        ];
    }

    /**
     * @param DtoFillFlags $flag
     * @param             $result
     *
     * @dataProvider data
     */
    public function testReflectionOptions(DtoFillFlags $flag, $result)
    {
        $this->assertEquals($result, $flag->reflectionOptions());
    }
}