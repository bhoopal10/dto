<?php

use Fnp\Dto\Set\SetModel;

class BasicTest extends PHPUnit_Framework_TestCase
{
    public function provideTestData()
    {
        return [
            [
                BasicDigitSet::ONE,
                'One',
                1,
            ],
            [
                BasicDigitSet::TWO,
                'Two',
                2,
            ],
            [
                BasicDigitSet::THREE,
                'Three',
                3,
            ],
            [
                BasicDigitSet::FOUR,
                NULL,
                NULL,
            ],
        ];
    }

    /**
     * @param $handle
     * @param $name
     * @param $value
     *
     * @dataProvider provideTestData
     */
    public function testVariables($handle, $name, $digit)
    {
        $digits = BasicDigitSet::make($handle);

        $this->assertEquals($name, $digits->name);
        $this->assertEquals($digit, $digits->digit);
    }

    /**
     * @param $handle
     * @param $name
     * @param $value
     *
     * @dataProvider provideTestData
     */
    public function testPluck($handle, $name, $digit)
    {
        $pluck = BasicDigitSet::pluck('name');

        $this->assertArrayHasKey($handle, $pluck);
        $this->assertEquals($name, $pluck[ $handle ]);

        $pluck = BasicDigitSet::pluck('digit');

        $this->assertArrayHasKey($handle, $pluck);
        $this->assertEquals($digit, $pluck[ $handle ]);

        if ($name) {
            $pluck = BasicDigitSet::pluck('digit', 'name');

            $this->assertArrayHasKey($name, $pluck);
            $this->assertEquals($digit, $pluck[ $name ]);
        }
    }
}

class BasicDigitSet extends SetModel
{
    const ONE   = 'one';
    const TWO   = 'two';
    const THREE = 'three';
    const FOUR  = 'four';

    public $name;
    public $digit;

    public function setOne()
    {
        $this->name  = 'One';
        $this->digit = 1;
    }

    public function setTwo()
    {
        $this->name  = 'Two';
        $this->digit = 2;
    }

    public function setThree()
    {
        $this->name  = 'Three';
        $this->digit = 3;
    }

}