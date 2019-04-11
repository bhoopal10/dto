<?php

use Fnp\Dto\Common\Flags\DtoFillFlags;
use Fnp\Dto\Common\Flags\DtoFlags;

class DtoFillTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @return array
     */
    public function data()
    {
        return [
            'Fill All by Not Passing any Flags' => [
                NULL,
                1, 1, 1,
            ],
            'Fill Public Only'                  => [
                DtoFlags::FILL_PUBLIC,
                1, NULL, NULL,
            ],
            'Fill Protected Only'               => [
                DtoFlags::FILL_PROTECTED,
                NULL, 1, NULL,
            ],
            'Fill Private Only'                 => [
                DtoFlags::FILL_PRIVATE,
                NULL, NULL, 1,
            ],
            'Fill Public & Protected'           => [
                [DtoFlags::FILL_PUBLIC, DtoFlags::FILL_PROTECTED],
                1, 1, NULL,
            ],
            'Fill Public & Private'             => [
                DtoFlags::FILL_PUBLIC + DtoFlags::FILL_PRIVATE,
                1, NULL, 1,
            ],
        ];
    }

    /**
     * @test
     * @dataProvider data
     */
    public function it_should_set_proper_properties($flags, $pub, $pro, $pri)
    {
        $model = new VisibilityModel;
        $model->fill(['pub' => 1, 'pro' => 1, 'pri' => 1], $flags);
        $props = $model->getAll();

        $this->assertEquals($pub, $props['pub']);
        $this->assertEquals($pro, $props['pro']);
        $this->assertEquals($pri, $props['pri']);
    }
}

class VisibilityModel
{
    use \Fnp\Dto\Common\DtoFill;

    public    $pub;
    protected $pro;
    private   $pri;

    public function getAll()
    {
        return [
            'pub' => $this->pub,
            'pro' => $this->pro,
            'pri' => $this->pri,
        ];
    }
}