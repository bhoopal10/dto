<?php


use Fnp\Dto\Common\Flags\DtoFlags;

class DtoToArrayFlagsTest extends \PHPUnit\Framework\TestCase
{
    public function data()
    {
        return [
            'Default Options'                   => [
                NULL, // Flags
                TRUE, // Serialize Objects
                FALSE, // Serialize String Providers
                FALSE, // Exclude Nulls
                FALSE, // Prefer String Providers
                ReflectionProperty::IS_PUBLIC +
                ReflectionProperty::IS_PROTECTED,
            ],
            'Dont Serialize Objects'            => [
                DtoFlags::TO_ARRAY_DONT_SERIALIZE_OBJECTS, // Flags
                FALSE, // Serialize Objects
                FALSE, // Serialize String Providers
                FALSE, // Exclude Nulls
                FALSE, // Prefer String Providers
                ReflectionProperty::IS_PUBLIC +
                ReflectionProperty::IS_PROTECTED,
            ],
            'Serialize Strings'                 => [
                DtoFlags::TO_ARRAY_SERIALIZE_STRING_PROVIDERS, // Flags
                TRUE, // Serialize Objects
                TRUE, // Serialize String Providers
                FALSE, // Exclude Nulls
                FALSE, // Prefer String Providers
                ReflectionProperty::IS_PUBLIC +
                ReflectionProperty::IS_PROTECTED,
            ],
            'Serialize Strings and Prefer'      => [
                DtoFlags::TO_ARRAY_SERIALIZE_STRING_PROVIDERS +
                DtoFlags::TO_ARRAY_PREFER_STRING_PROVIDERS, // Flags
                TRUE, // Serialize Objects
                TRUE, // Serialize String Providers
                FALSE, // Exclude Nulls
                TRUE, // Prefer String Providers
                ReflectionProperty::IS_PUBLIC +
                ReflectionProperty::IS_PROTECTED,
            ],
            'Serialize Strings but not Objects' => [
                DtoFlags::TO_ARRAY_DONT_SERIALIZE_OBJECTS +
                DtoFlags::TO_ARRAY_SERIALIZE_STRING_PROVIDERS, // Flags
                FALSE, // Serialize Objects
                TRUE, // Serialize String Providers
                FALSE, // Exclude Nulls
                FALSE, // Prefer String Providers
                ReflectionProperty::IS_PUBLIC +
                ReflectionProperty::IS_PROTECTED,
            ],
        ];
    }

    /**
     * @test
     * @dataProvider data
     *
     * @param $flags
     * @param $serializeObjects
     * @param $serializeStringProviders
     * @param $excludeNulls
     * @param $preferStringProviders
     * @param $reflectionOptions
     */
    public function test_the_methods(
        $flags,
        $serializeObjects,
        $serializeStringProviders,
        $excludeNulls,
        $preferStringProviders,
        $reflectionOptions
    ) {
        $f = DtoFlags::make($flags);

        $this->assertEquals(
            $serializeObjects,
            $f->serializeObjects(),
            'Serialize Objects'
        );

        $this->assertEquals(
            $serializeStringProviders,
            $f->serializeStringProviders(),
            'Serialize String Providers'
        );

        $this->assertEquals(
            $excludeNulls,
            $f->excludeNulls(),
            'Exclude Nulls'
        );

        $this->assertEquals(
            $preferStringProviders,
            $f->preferStringProviders(),
            'Prefer String Providers'
        );

        $this->assertEquals(
            $reflectionOptions,
            $f->toArrayReflectionOptions(),
            'Reflection Options'
        );
    }
}
