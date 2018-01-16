<?php

use Fnp\Dto\Mapper\ClassMap;

class ClassMapTest extends PHPUnit_Framework_TestCase
{
    public function testClassesAndHandles()
    {
        $this->assertEquals(['A', 'B', 'C'], AClassMap::classes());
        $this->assertEquals(['theA','theB','theC'], AClassMap::handles());
        $this->assertTrue(AClassMap::hasClass(A::class));
        $this->assertTrue(AClassMap::hasClass(C::class));
        $this->assertFalse(AClassMap::hasClass(D::class));
        $this->assertTrue(AClassMap::hasHandle('theA'));
        $this->assertTrue(AClassMap::hasHandle('theC'));
        $this->assertFalse(AClassMap::hasHandle('THE_C'));
    }

    public function testGets()
    {
        $this->assertEquals('theA', AClassMap::getHandle(A::class));
        $this->assertEquals('theC', AClassMap::getHandle(C::class));
        $this->assertEquals(NULL,  AClassMap::getHandle(D::class));
        $this->assertEquals(A::class, AClassMap::getClass('theA'));
        $this->assertEquals(B::class, AClassMap::getClass('theB'));
        $this->assertEquals(NULL, AClassMap::getClass('theD'));
    }

    public function testCustomHandle()
    {
        $this->assertEquals(['A', 'B', 'C'], AClassMapWithCustomHandle::classes());
        $this->assertEquals(['THE_A','THE_B','THE_C'], AClassMapWithCustomHandle::handles());
        $this->assertTrue(AClassMapWithCustomHandle::hasClass(A::class));
        $this->assertTrue(AClassMapWithCustomHandle::hasClass(C::class));
        $this->assertFalse(AClassMapWithCustomHandle::hasClass(D::class));
        $this->assertTrue(AClassMapWithCustomHandle::hasHandle('THE_A'));
        $this->assertTrue(AClassMapWithCustomHandle::hasHandle('THE_C'));
        $this->assertFalse(AClassMapWithCustomHandle::hasHandle('theC'));
    }

    public function testExtensions()
    {
        AClassMap::extend('THE_F', F::class);
        AClassMap::extend('another_f', F::class);
        AClassMap::extend('yetAnotherF', F::class);
        $this->assertTrue(AClassMap::hasHandle('theF'));
        $this->assertTrue(AClassMap::hasHandle('anotherF'));
        $this->assertTrue(AClassMap::hasHandle('yetAnotherF'));
        $this->assertEquals(['theA','theB','theC','theF','anotherF','yetAnotherF'], AClassMap::handles());
        $this->assertEquals(F::class, AClassMap::getClass('theF'));
        $this->assertEquals(F::class, AClassMap::getClass('anotherF'));
        $this->assertFalse(AClassMapWithCustomHandle::hasHandle('THE_F'));
    }
}

class AClassMap extends ClassMap
{
    const THE_A = A::class;
    const THE_B = B::class;
    const THE_C = C::class;
}

class AClassMapWithCustomHandle extends ClassMap
{
    const THE_A = A::class;
    const THE_B = B::class;
    const THE_C = C::class;

    protected static function generateHandle($string)
    {
        return $string;
    }
}

class A
{

}

class B
{

}

class C
{

}

class D
{

}

class F
{

}