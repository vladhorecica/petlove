<?php
// @codingStandardsIgnoreFile
namespace Util\Tests\Unit\Data\DataHelper;

use Util\Data\DataHelper;
use Util\Data\DataProcessingError;

class HasTest extends \PHPUnit_Framework_TestCase
{
    /**
     */
    public function testSuccess()
    {
        $this->assertTrue((new DataHelper(['foo' => 'bar']))->has('foo'));
        $this->assertTrue((new DataHelper(['foo' => null]))->has('foo'));
        $this->assertFalse((new DataHelper(['bar' => 'foo']))->has('foo'));
    }

    /**
     */
    public function testFailure()
    {
        $this->setExpectedException(DataProcessingError::class);
        (new DataHelper('foo'))->has('foo');
    }
}
