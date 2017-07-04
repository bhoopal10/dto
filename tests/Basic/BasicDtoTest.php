<?php

namespace Fnp\Dto\Test\Basic;

use Faker\Factory;
use Fnp\Dto\Test\Basic\Dto\UserData;
use Illuminate\Support\Arr;

class BasicDtoTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function checkIfCanBeInitializedWrittenAndRead()
    {
        $faker = Factory::create();

        $id       = $faker->uuid;
        $name     = $faker->name;
        $email    = $faker->email;
        $note     = $faker->sentence(20);
        $password = $faker->password(10);

        $dto        = new UserData();
        $dto->id    = $id;
        $dto->name  = $name;
        $dto->email = $email;
        $dto->setPassword($password);
        $dto->setNotes($note);

        $dtoArray = $dto->toArray();

        $this->assertArrayHasKey('id', $dtoArray);
        $this->assertEquals($id, $dto->id);
        $this->assertEquals($id, $dtoArray['id']);

        $this->assertArrayHasKey('name', $dtoArray);
        $this->assertEquals($name, $dto->name);
        $this->assertEquals($name, $dtoArray['name']);

        $this->assertArrayHasKey('email', $dtoArray);
        $this->assertEquals($email, $dto->email);
        $this->assertEquals($email, $dtoArray['email']);

        $this->assertArrayHasKey('notes', $dtoArray);
        $this->assertEquals($note, Arr::get($dtoArray, 'notes'));

        $this->assertArrayNotHasKey('password', $dtoArray);
    }
}