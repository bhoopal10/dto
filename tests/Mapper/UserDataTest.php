<?php

namespace Fnp\Dto\Test\Mapper;

use Fnp\Dto\Test\Mapper\Data\UserData;

class UserDataTest extends \PHPUnit_Framework_TestCase
{
    public function generateData()
    {
        return [

            'Simple Data' => [
                [
                    'user_name'  => 'user123',
                    'first_name' => 'John',
                    'last_name'  => 'Doe',
                    'email'      => 'john.doe@example.com',
                    'birth_date' => NULL,
                ],
                [
                    'userName' => 'user123',
                    'forename' => 'John',
                    'surname'  => 'Doe',
                    'fullName' => 'John Doe',
                    'email'    => 'john.doe@example.com',
                    'dob'      => NULL,
                    'notes'    => NULL,
                ],
            ],

            'With Fill Modifiers' => [
                [
                    'user_name'  => NULL,
                    'first_name' => 'john',
                    'last_name'  => 'doe',
                    'email'      => 'John.Doe@example.COM',
                    'birth_date' => '1975-12-24',
                ],
                [
                    'userName' => NULL,
                    'forename' => 'John',
                    'surname'  => 'Doe',
                    'fullName' => 'John Doe',
                    'email'    => 'john.doe@example.com',
                    'dob'      => '1975-12-24',
                    'notes'    => NULL,
                ],
            ],

            'Incorrect date' => [
                [
                    'user_name'  => NULL,
                    'first_name' => 'john',
                    'last_name'  => 'doe',
                    'email'      => 'John.Doe@example.COM',
                    'birth_date' => '1975-aa-12',
                ],
                [
                    'userName' => NULL,
                    'forename' => 'John',
                    'surname'  => 'Doe',
                    'fullName' => 'John Doe',
                    'email'    => 'john.doe@example.com',
                    'dob'      => NULL,
                    'notes'    => NULL,
                ],
            ],

        ];
    }

    /**
     * @param $input
     * @param $output
     *
     * @dataProvider generateData
     */
    public function testData($input, $output)
    {
        $model = UserData::make($input);

        $this->assertEquals($output, $model->toArray());
    }
}