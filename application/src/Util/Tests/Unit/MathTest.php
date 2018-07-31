<?php

namespace Util\Tests\Unit;

use Util\Util\Math;

class MathTest extends \PHPUnit_Framework_TestCase
{
    /**
     */
    public function testIntDiv()
    {
        $this->assertSame(2, Math::intdiv(4, 2));
        $this->assertSame(2, Math::intdiv(5, 2));
        $this->assertSame(-3, Math::intdiv(-10, 3));
    }

    /**
     */
    public function testIntDivDivideByZero()
    {
        $this->setExpectedException(\InvalidArgumentException::class);
        Math::intdiv(5, 0);
    }
}
