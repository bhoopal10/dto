<?php

use Fnp\Dto\Common\Helper\Str;
use Fnp\Dto\Set\PersistenceSetModel;

class PersistenceSetModelTest extends PHPUnit_Framework_TestCase
{
    public function provideTestData()
    {
        return [
            [
                BasicPersistenceDigitSet::ONE,
                'One',
                1,
            ],
            [
                BasicPersistenceDigitSet::TWO,
                'Two',
                2,
            ],
            [
                BasicPersistenceDigitSet::THREE,
                'Three',
                3,
            ],
            [
                BasicPersistenceDigitSet::FOUR,
                NULL,
                NULL,
            ],
            [
                BasicPersistenceDigitSet::TWENTY_TWO,
                'The Twenty Two',
                222,
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
        $digits = BasicPersistenceDigitSet::make($handle);

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
        $pluck = BasicPersistenceDigitSet::pluck('name');

        $this->assertArrayHasKey($handle, $pluck);
        $this->assertEquals($name, $pluck[ $handle ]);

        $pluck = BasicPersistenceDigitSet::pluck('digit');

        $this->assertArrayHasKey($handle, $pluck);
        $this->assertEquals($digit, $pluck[ $handle ]);

        if ($name) {
            $pluck = BasicPersistenceDigitSet::pluck('digit', 'name');

            $this->assertArrayHasKey($name, $pluck);
            $this->assertEquals($digit, $pluck[ $name ]);
        }
    }

    /**
     * @param $handle
     *
     * @dataProvider provideTestData
     * @throws Exception
     */
    public function testHas($handle)
    {
        $this->assertTrue(BasicPersistenceDigitSet::has($handle), 'Handle ' . $handle . ' should exist but it doesn\'t!');
        $this->assertFalse(BasicPersistenceDigitSet::has(Str::random(10)));
    }

    /**
     * @param $handle
     *
     * @dataProvider provideTestData
     */
    public function testHandle($handle)
    {
        $this->assertEquals($handle, BasicPersistenceDigitSet::make($handle)->handle());
    }
}

class BasicPersistenceDigitSet extends PersistenceSetModel
{
    const ONE        = 'one';
    const TWO        = 'two';
    const THREE      = 'three';
    const FOUR       = 'four';
    const TWENTY_TWO = 'theTwentyTwo';

    public $name;
    public $digit;


    protected function retrieve($handle)
    {
        $data = [
            [
                'handle' => 'one',
                'name'   => 'One',
                'digit'  => 1,
            ],
            [
                'handle' => 'two',
                'name'   => 'Two',
                'digit'  => 2,
            ],
            [
                'handle' => 'three',
                'name'   => 'Three',
                'digit'  => 3,
            ],
            [
                'handle' => 'theTwentyTwo',
                'name'   => 'The Twenty Two',
                'digit'  => 222,
            ],
        ];

        foreach ($data as $record) {
            if ($record['handle'] == $handle) {
                return $record;
            }
        }
    }
}