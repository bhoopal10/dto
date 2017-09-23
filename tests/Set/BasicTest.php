<?php

use Fnp\Dto\Set\SetModel;
use Illuminate\Support\Str;

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
            [
                BasicDigitSet::TWENTY_TWO,
                'The Twenty Two',
                22,
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

    /**
     * @param $handle
     *
     * @dataProvider provideTestData
     */
    public function testHas($handle)
    {
        $this->assertTrue(BasicDigitSet::has($handle), 'Handle ' . $handle . ' should exist but it doesn\'t!');
        $this->assertFalse(BasicDigitSet::has(Str::random(10)));
    }

    /**
     * @param $handle
     *
     * @dataProvider provideTestData
     */
    public function testHandle($handle)
    {
        $this->assertEquals($handle, BasicDigitSet::make($handle)->handle());
    }
}

class BasicDigitSet extends SetModel
{
    const ONE        = 'one';
    const TWO        = 'two';
    const THREE      = 'three';
    const FOUR       = 'four';
    const TWENTY_TWO = 'theTwentyTwo';

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

    public function setTwentyTwo()
    {
        $this->name  = 'The Twenty Two';
        $this->digit = 22;
    }

}