<?php

require_once 'mapper/Source.php';
require_once 'mapper/Mapper.php';
require_once 'mapper/Destination.php';
require_once 'mapper/Nested.php';

class MapperTest extends PHPUnit_Framework_TestCase
{
    public function generateUserData()
    {
        $faker = \Faker\Factory::create();
        $data = [];

        for($i = 0; $i < 50; $i++) {
            $data[] = [
                $faker->userName,
                $faker->password,
            ];
        }

        return $data;
    }

    /**
     * @dataProvider generateUserData
     * @test
     */
    public function testMapping($userName, $password)
    {
        $source = new Source();
        $source->name_of_the_user = $userName;
        $source->user_password = $password;

        $mapper = Mapper::make($source);

        $this->assertEquals($userName, $mapper->userName);
        $this->assertEquals($password, $mapper->password);

        $destination = Destination::make($mapper);

        $this->assertEquals($userName, $destination->userName);
        $this->assertEquals($password, $destination->password);
    }

    /**
     * @test
     */
    public function testNestedStructures()
    {
        $structure = [
            'one'   => 1,
            'two'   => [
                'a' => '1',
                'b' => '2',
                'c' => [
                    'x' => 101,
                    'y' => 202,
                    'z' => 303,
                ],
            ],
            'three' => 3,
        ];

        $mapper = Nested::make($structure);

        $this->assertEquals(1, $mapper->getOne());
        $this->assertEquals('2', $mapper->getTwo());
        $this->assertEquals(303, $mapper->getThree());
    }
}