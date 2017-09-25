<?php

use Faker\Factory;
use Fnp\Dto\Common\DtoArrayAccess;
use Fnp\Dto\Common\DtoToArray;
use Fnp\Dto\Contract\DtoModelContract;

class BasicDtoTest extends \PHPUnit_Framework_TestCase
{
    public function generateUsers()
    {
        $faker = Factory::create();
        $users = [];
        for ($i = 0; $i <= 50; $i++) {
            $users[] = [
                $faker->userName,
                $faker->email,
                $faker->name,
                $faker->password,
            ];
        }

        return $users;
    }

    /**
     * @param $userName
     * @param $email
     * @param $name
     * @param $password
     *
     * @dataProvider generateUsers
     */
    public function testPropertiesAndSetters($userName, $email, $name, $password)
    {
        $model = new UserDto($userName, $email, $name);
        $model->setPassword($password);

        $this->assertEquals($userName, $model->getUserName());
        $this->assertEquals($email, $model->getEmail());
        $this->assertEquals($name, $model->getName());
        $this->assertNotEquals($password, $model->getPassword());
        $this->assertEquals(sha1($password), $model->getPassword());
    }

    /**
     * @param $userName
     * @param $email
     * @param $name
     * @param $password
     *
     * @dataProvider generateUsers
     */
    public function testSerialization($userName, $email, $name, $password)
    {
        $model = new UserDto($userName, $email, $name);
        $model->setPassword($password);

        $array = $model->toArray();

        $this->assertArrayHasKey('userName', $array);
        $this->assertArrayHasKey('email', $array);
        $this->assertArrayHasKey('name', $array);

        /*
         * Private properties should not be serialized
         */
        $this->assertArrayNotHasKey('password', $array);

        $this->assertEquals($userName, $array['userName']);
        $this->assertEquals($email, $array['email']);
        $this->assertEquals($name, $array['name']);
    }
  
    /**
     * @param $userName
     * @param $email
     * @param $name
     * @param $password
     *
     * @dataProvider generateUsers
     */
    public function testTraversable($userName, $email, $name, $password)
    {
        $model = new UserDto($userName, $email, $name);
        $model->setPassword($password);
        $data = $model->toArray();

        foreach($model as $key=>$value) {
            $this->assertEquals($value, $data[$key]);
        }
    }
}

class UserDto implements DtoModelContract, \ArrayAccess
{
    use DtoArrayAccess;
    use DtoToArray;

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