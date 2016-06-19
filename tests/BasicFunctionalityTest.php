<?php

use Illuminate\Support\Str;

require_once 'flex/Cars.php';

class BasicFunctionalityTest extends PHPUnit_Framework_TestCase
{
    protected $data = [
        'alfa_romeo' => 'Julietta',
        'bmw'        => 'i3',
        'citroen'    => 'C3',
        'jaguar'     => 'XJ',
        'saab'       => '900',
        'tesla'      => 's',
        'volvo'      => 'V90',
    ];
    
    public function testArrayApply()
    {
        $cars = Cars::make($this->data);

        $this->assertEquals(count($this->data), count($cars->toArray()));

        foreach ($this->data as $key => $value) {
            $this->assertEquals($value, $cars->toArray()[ Str::camel($key) ]);
        }
        
        return $cars;
    }

    /**
     * @param $cars
     * @depends testArrayApply
     */
    public function testDtoApply($cars)
    {
        $model = Cars::make($cars);

        $this->assertEquals(count($this->data), count($model->toArray()));

        foreach ($this->data as $key => $value) {
            $this->assertEquals($value, $model->toArray()[ Str::camel($key) ]);
        }
    }
}