<?php

use Illuminate\Support\Str;

class BasicFunctionalityTest extends PHPUnit_Framework_TestCase
{
    public function testTest()
    {
        $data = [
            'alfa_romeo' => 'Julietta',
            'bmw'        => 'i3',
            'citroen'    => 'C3',
            'jaguar'     => 'XJ',
            'saab'       => '900',
            'tesla'      => 's',
            'volvo'      => 'V90',
        ];

        $cars = Cars::make($data);

        $this->assertEquals(count($data), count($cars->toArray()));

        foreach ($data as $key => $value) {
            $this->assertEquals($value, $cars->toArray()[ Str::camel($key) ]);
        }
    }
}