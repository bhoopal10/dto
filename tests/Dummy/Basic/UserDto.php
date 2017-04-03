<?php

namespace Fnp\Dto\Test\Dummy\Basic;

use Fnp\Dto\Basic\DtoModel;

class UserDto extends DtoModel
{
    protected $userName;
    protected $email;
    protected $name;
    private   $password;

    public function __construct($userName, $email, $name)
    {
        $this->userName = $userName;
        $this->email    = $email;
        $this->name     = $name;
    }

    /**
     * @return mixed
     */
    public function getUserName()
    {
        return $this->userName;
    }

    /**
     * @param mixed $userName
     *
     * @return UserDto
     */
    public function setUserName($userName)
    {
        $this->userName = $userName;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     *
     * @return UserDto
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     *
     * @return UserDto
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     *
     * @return UserDto
     */
    public function setPassword($password)
    {
        /*
         * Please note this is purely for testing purposes.
         * Kids do not hash your passwords this way.
         */
        $this->password = sha1($password);

        return $this;
    }

}