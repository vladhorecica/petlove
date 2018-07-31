<?php
// @codingStandardsIgnoreFile
namespace Util\Tests\Unit\Data\DataHelper;

use Util\Data\DataProcessingError;
use Util\Data\DataHelper;

class GetStringTest extends \PHPUnit_Framework_TestCase
{
    /**
     */
    public function testInvalidString()
    {
        $this->setExpectedException(DataProcessingError::class);
        (new DataHelper([]))->getString();
    }

    /**
     */
    public function testNullString()
    {
        $this->setExpectedException(DataProcessingError::class);
        (new DataHelper(null))->getString();
    }

    /**
     */
    public function testValidString()
    {
        $this->assertSame('hello', (new DataHelper('hello'))->getString());
    }

    /**
     */
    public function testOptionalString()
    {
        $this->assertNull((new DataHelper(null))->maybe()->getString());
    }
}
