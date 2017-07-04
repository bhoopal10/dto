<?php

namespace Fnp\Dto\Test\Basic\Dto;

use Fnp\Dto\Basic\DtoModel;

class UserData extends DtoModel
{
    public    $id;
    public    $email;
    public    $name;
    protected $notes;
    private   $password;

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @param mixed $notes
     */
    public function setNotes($notes)
    {
        $this->notes = $notes;
    }
}