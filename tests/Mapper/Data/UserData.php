<?php

namespace Fnp\Dto\Test\Mapper\Data;

use Carbon\Carbon;
use Fnp\Dto\Mapper\MapperModel;

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