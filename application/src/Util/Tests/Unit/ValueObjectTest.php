<?php
// @codingStandardsIgnoreFile
namespace Util\Tests\Unit;

use Util\Util\Val;
use Util\Value\ScalarValueObject;

class ValueObjectTest extends \PHPUnit_Framework_TestCase
{
    /**
     *
     */
    public function testEquals()
    {
        $this->assertTrue(Val::equals(new ValueObjectExample('F34'), new ValueObjectExample('F34')));
    }

    /**
     */
    public function testNotEquals()
    {
        $this->assertFalse(Val::equals(new ValueObjectExample('F34'), new ValueObjectExample('6H8')));
    }

    /**
     */
    public function testNull()
    {
        $this->assertTrue(Val::equals(null, null));
        $this->assertFalse(Val::equals(new ValueObjectExample('F34'), null));
    }

    /**
     */
    public function testIn()
    {
        $collection = [new ValueObjectExample('F34'), new ValueObjectExample('A21')];
        $this->assertTrue(Val::in($collection, new ValueObjectExample('F34')));
        $collection = [new ValueObjectExample('B11'), new ValueObjectExample('A21')];
        $this->assertFalse(Val::in($collection, new ValueObjectExample('F34')));
        $collection = [new ValueObjectExample('F34'), new ValueObjectExample('A21')];
        $this->assertFalse(Val::in($collection, null));
    }
}
// @codingStandardsIgnoreStart
class ValueObjectExample extends ScalarValueObject
{
}
