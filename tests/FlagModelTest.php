<?php

class FlagModelTest extends \PHPUnit\Framework\TestCase
{
    public function data()
    {
        return [
            [[],FALSE, FALSE, FALSE],
            [[FlagA::SET_A], TRUE, FALSE, FALSE],
            [[FlagA::SET_B], FALSE, TRUE, FALSE],
            [[FlagA::SET_A,FlagA::SET_B], TRUE, TRUE, TRUE],
        ];
    }

    /**
     * @param $flags
     * @param $isA
     * @param $isB
     * @param $isBoth
     * @dataProvider data
     */
    public function testFlags($flags, $isA, $isB, $isBoth)
    {
        $f = new FlagA($flags);

        $this->assertEquals($isA, $f->is_a, 'Checking A');
        $this->assertEquals($isB, $f->is_b, 'Checking B');
        $this->assertEquals($isBoth, $f->is_both, 'Checking Both');
    }

    public function testAdd()
    {
        $this->assertTrue(TRUE);
    }

}

class FlagA extends \Fnp\Dto\Flag\FlagModel
{
    const SET_A = 100;
    const SET_B = 110;

    public $is_a;
    public $is_b;
    public $is_both;

    public function getIsA()
    {
        return $this->has(self::SET_A);
    }

    public function getIsB()
    {
        return $this->has(self::SET_B);
    }

    public function getIsBoth()
    {
        return $this->has([self::SET_A,self::SET_B]);
    }
}