<?php

class UserDto extends \Fnp\Dto\Basic\DtoModel
{
    protected $id;
    protected $email;

    public function __construct($userId, $email)
    {
        $this->id    = $userId;
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     *
     * @return UserDto
     */
    public function setId($id)
    {
        $this->id = $id;

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
    
    
}