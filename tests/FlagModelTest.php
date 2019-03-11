<?php

class FlagModelTest extends \PHPUnit\Framework\TestCase
{
    public function data()
    {
        return [
            [NULL, FALSE, FALSE, FALSE, FALSE],

            [FruitsFlagsModel::APPLE, TRUE, FALSE, FALSE],
            [FruitsFlagsModel::ORANGE, FALSE, TRUE, FALSE],
            [FruitsFlagsModel::PEAR, FALSE, FALSE, TRUE],

            [FruitsFlagsModel::APPLE + FruitsFlagsModel::ORANGE, TRUE, TRUE, FALSE],
            [FruitsFlagsModel::APPLE + FruitsFlagsModel::PEAR, TRUE, FALSE, TRUE],
            [FruitsFlagsModel::APPLE + FruitsFlagsModel::ORANGE + FruitsFlagsModel::PEAR, TRUE, TRUE, TRUE],

            [FruitsFlagsModel::ORANGE + FruitsFlagsModel::APPLE, TRUE, TRUE, FALSE],
            [FruitsFlagsModel::ORANGE + FruitsFlagsModel::PEAR, FALSE, TRUE, TRUE],
            [FruitsFlagsModel::ORANGE + FruitsFlagsModel::APPLE + FruitsFlagsModel::PEAR, TRUE, TRUE, TRUE],

            [FruitsFlagsModel::PEAR + FruitsFlagsModel::APPLE, TRUE, FALSE, TRUE],
            [FruitsFlagsModel::PEAR + FruitsFlagsModel::ORANGE, FALSE, TRUE, TRUE],
            [FruitsFlagsModel::PEAR + FruitsFlagsModel::APPLE + FruitsFlagsModel::ORANGE, TRUE, TRUE, TRUE],
        ];
    }

    /**
     * @param $flags
     * @param $isA
     * @param $isB
     * @param $isBoth
     *
     * @dataProvider data
     */
    public function testFlags($flags, $isApple, $isOrange, $isPear)
    {
        $f = new FruitsFlagsModel($flags);

        $this->assertEquals($isApple, $f->has(FruitsFlagsModel::APPLE), 'Checking Apple');
        $this->assertEquals($isOrange, $f->has(FruitsFlagsModel::ORANGE), 'Checking Orange');
        $this->assertEquals($isPear, $f->has(FruitsFlagsModel::PEAR), 'Checking Pear');
    }

}

class FruitsFlagsModel extends \Fnp\Dto\Flag\FlagModel
{
    const APPLE  = 0b001; // 1
    const ORANGE = 0b010; // 2
    const PEAR   = 0b100; // 4
}