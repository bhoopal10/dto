<?php

class Nested extends \Fnp\Dto\Mapper\MapperModel
{
    protected $one = 'one';
    protected $two = 'two.b';
    protected $three = 'two.c.z';

    /**
     * @return string
     */
    public function getOne()
    {
        return $this->one;
    }

    /**
     * @return string
     */
    public function getTwo()
    {
        return $this->two;
    }

    /**
     * @return string
     */
    public function getThree()
    {
        return $this->three;
    }


}