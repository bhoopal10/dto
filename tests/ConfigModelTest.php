<?php

use Fnp\Dto\Config\ConfigModel;

class ConfigModelTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @test
     */
    public function it_uses_default_values_when_no_env_specified()
    {
        $config = new TestConfig();

        $this->assertEquals(NULL, $config->one);
        $this->assertEquals(2, $config->two);
        $this->assertEquals(3, $config->three);
    }
}

class TestConfig extends ConfigModel
{
    public $one = 'ONE';
    public $two = 'TWO=2';
    public $three = 'THREE=3';
}