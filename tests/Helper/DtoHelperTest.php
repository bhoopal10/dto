<?php

namespace Fnp\Dto\Test\Helper;

use Fnp\Dto\Common\Helper\DtoHelper;

class DtoHelperTest extends \PHPUnit_Framework_TestCase
{
    public function generateMethodNames()
    {
        return [
            'All Lower Case'              => [
                'get', 'name', NULL, 'getName',
            ],
            'All Lower Case with Suffix'  => [
                'get', 'name', 'attribute', 'getNameAttribute',
            ],
            'All Lower without Prefix'    => [
                '', 'name', 'attribute', 'nameAttribute',
            ],
            'Snake Case Name'             => [
                'fill', 'post_code', NULL, 'fillPostCode',
            ],
            'Snake Case Name with Suffix' => [
                'fill', 'post_code', 'Value', 'fillPostCodeValue',
            ],
            'Snake Case without Prefix'   => [
                NULL, 'post_code', 'Value', 'postCodeValue',
            ],
            'Upper Case Name'             => [
                'fill', 'POST_CODE', NULL, 'fillPostCode',
            ],
            'Upper Case with Suffix'      => [
                'fill', 'POST_CODE', 'attributeValue', 'fillPostCodeAttributeValue',
            ],
            'Upper Case without Prefix'   => [
                '', 'POST_CODE', 'value', 'postCodeValue',
            ],
            'Upper Case one Word'         => [
                'get', 'VALUES', NULL, 'getValues',
            ],
            'Just Name Upper'             => [
                NULL, 'VALUES', NULL, 'values',
            ],
            'Just Name Lower'             => [
                NULL, 'values', NULL, 'values',
            ],
            'Just Name Snake'             => [
                NULL, 'post_code', NULL, 'postCode',
            ],
            'Just Name Camel'             => [
                NULL, 'postCode', NULL, 'postCode',
            ],
            'Dot Separated'               => [
                'set', 'dot.separated.value', NULL, 'setDotSeparatedValue',
            ],
            'Dash Separated'               => [
                '', 'dash-separated-value', 'Attribute', 'dashSeparatedValueAttribute',
            ],
        ];
    }

    /**
     * @test
     *
     * @param $prefix
     * @param $name
     * @param $suffix
     * @param $methodName
     *
     * @dataProvider generateMethodNames
     */
    public function testMethodNames($prefix, $name, $suffix, $methodName)
    {
        $this->assertEquals($methodName, DtoHelper::methodName($prefix, $name, $suffix));
    }
}