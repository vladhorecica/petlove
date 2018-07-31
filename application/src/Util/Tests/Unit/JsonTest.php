<?php
// @codingStandardsIgnoreFile
namespace Util\Tests\Unit;

use Util\Util\Json;

class JsonTest extends \PHPUnit_Framework_TestCase
{
    /**
     */
    public function testThrowsException()
    {
        $this->setExpectedException(\RuntimeException::class);
        Json::decode('invalid');
    }

    /**
     */
    public function testDecodesToArray()
    {
        $this->assertInternalType('array', Json::decode('{}'));
    }
}
