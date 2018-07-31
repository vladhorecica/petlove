<?php
// @codingStandardsIgnoreFile
namespace Util\Tests\Unit;

use Util\Value\Enum;

class EnumTest extends \PHPUnit_Framework_TestCase
{
    /**
     */
    public function testEquality()
    {
        $enum1 = ExampleEnum::foo();
        $enum2 = ExampleEnum::foo();
        $this->assertTrue($enum1->equals($enum2));
    }

    /**
     */
    public function testInequality()
    {
        $enum1 = ExampleEnum::foo();
        $enum2 = ExampleEnum::bar();
        $this->assertFalse($enum1->equals($enum2));
    }

    /**
     */
    public function testGetAll()
    {
        $all = ExampleEnum::getAll();
        $this->assertCount(2, $all);
        $this->assertTrue($all[0]->equals(ExampleEnum::foo()));
        $this->assertTrue($all[1]->equals(ExampleEnum::bar()));
    }

    /**
     */
    public function testSerialization()
    {
        $foo = ExampleEnum::foo();
        $foo2 = unserialize(serialize($foo));
        $this->assertTrue($foo->equals($foo2));
    }

    /**
     */
    public function testGetName()
    {
        $foo = ExampleEnum::foo();
        $this->assertSame('foo', $foo->getValue());
    }
}
/**
 * @method static ExampleEnum foo()
 * @method static ExampleEnum bar()
 */
class ExampleEnum extends Enum
{
    const VALUES = ['foo', 'bar'];
}
