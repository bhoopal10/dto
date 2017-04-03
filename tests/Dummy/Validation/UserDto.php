<?php

namespace Fnp\Dto\Test\Dummy\Validation;

use Fnp\Dto\Common\DtoValidate;

class UserDto extends \Fnp\Dto\Flex\DtoModel
{
    use DtoValidate;

    public $name;
    public $email;
    public $password;

    /**
     * Provides validation rules
     *
     * @return array
     */
    public function validationRules()
    {
        return [
            'name'     => 'required',
            'email'    => 'required|email',
            'password' => 'requires',
        ];
    }

    public function validationMessages()
    {
        return [
            'name.required'  => 'Please provide User Name.',
            'email.required' => 'Please provide Email Address.',
            'email.email'    => 'Incorrect Email Address provided.',
            'password'       => 'Password is required',
        ];
    }
}