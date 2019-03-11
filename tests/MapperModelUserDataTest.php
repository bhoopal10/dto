<?php

use Carbon\Carbon;
use Fnp\Dto\Common\Flags\DtoToArrayFlags;
use Fnp\Dto\Mapper\MapperModel;

class MapperModelUserDataTest extends \PHPUnit_Framework_TestCase
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

        $this->assertEquals($output, $model->toArray(DtoToArrayFlags::DONT_SERIALIZE_STRING_PROVIDERS));
    }
}

class UserData extends MapperModel
{
    public $userName = 'user_name';
    public $fullName = '.';
    public $forename = 'first_name';
    public $surname  = 'last_name';
    public $email    = 'email';
    public $dob      = 'birth_date';
    public $notes;

    public function fillForename($forename)
    {
        return ucwords($forename);
    }

    public function fillSurname($surname)
    {
        return ucwords($surname);
    }

    public function fillFullName($data)
    {
        return ucfirst($data['first_name']) . ' ' .
               ucfirst($data['last_name']);
    }

    public function fillEmail($userName)
    {
        return strtolower($userName);
    }

    public function fillDob($dob)
    {
        if (!$dob) {
            return NULL;
        }

        try {
            return Carbon::createFromFormat('Y-m-d', $dob);
        } catch (\Exception $e) {
            return NULL;
        }
    }

    public function getDob()
    {
        if (!$this->dob) {
            return NULL;
        }

        return $this->dob->toDateString();
    }

}