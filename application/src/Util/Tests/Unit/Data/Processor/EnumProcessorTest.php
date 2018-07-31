<?php
// @codingStandardsIgnoreFile
namespace Util\Tests\Unit\Data\Processor;

use Util\Data\DataHelper;
use Util\Data\DataProcessingError;
use Util\Data\Processor\EnumProcessor;
use Util\Value\Enum;

class EnumProcessorTest extends \PHPUnit_Framework_TestCase
{
    /**
     */
    public function testCaseSensitive()
    {
        $this->setExpectedException(DataProcessingError::class);
        $enum = (new DataHelper('FOO'))
            ->process(new EnumProcessor(ExampleEnum::class))
            ->get();
        $this->assertTrue(ExampleEnum::foo()->equals($enum));
    }
}

// @codingStandardsIgnoreStart
/**
 * @method static ExampleEnum foo()
 * @method static ExampleEnum bar()
 */
class ExampleEnum extends Enum
{
    const VALUES = ['foo', 'bar'];
}
