<?php
// @codingStandardsIgnoreFile
namespace Util\Tests\Unit\Validation;

use Util\Validation\Types;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\ValidatorBuilder;

class TypesTest extends \PHPUnit_Framework_TestCase
{
    /** @var ValidatorInterface */
    private $validator;

    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        parent::setUp();
        $this->validator = (new ValidatorBuilder())->getValidator();
    }

    /**
     */
    public function testEmpty()
    {
        $this->assertNotEmpty($this->validator->validate(123, new Types([])));
    }

    /**
     */
    public function testMulti()
    {
        $this->assertEmpty($this->validator->validate('foo', new Types(['string', 'integer'])));
        $this->assertNotEmpty($this->validator->validate(123, new Types(['string', 'float'])));
    }

    /**
     */
    public function testValidateScalar()
    {
        $this->assertEmpty($this->validator->validate('foo', new Types(['string'])));
        $this->assertNotEmpty($this->validator->validate(123, new Types(['string'])));
        $this->assertEmpty($this->validator->validate(true, new Types(['boolean'])));
    }

    /**
     */
    public function testCoercion()
    {
        $this->assertNotEmpty($this->validator->validate('123', new Types(['integer'])));
    }

    /**
     */
    public function testAlias()
    {
        $this->assertEmpty($this->validator->validate(123, new Types(['int'])));
        $this->assertEmpty($this->validator->validate(123, new Types(['integer'])));
        $this->assertEmpty($this->validator->validate(true, new Types(['bool'])));
        $this->assertEmpty($this->validator->validate(true, new Types(['boolean'])));
    }

    /**
     */
    public function testNull()
    {
        $this->assertEmpty($this->validator->validate(null, new Types(['string'])));
    }

    /**
     */
    public function testClass()
    {
        $this->assertEmpty($this->validator->validate(new \RuntimeException(), new Types([\RuntimeException::class])));
        $this->assertEmpty($this->validator->validate(new \RuntimeException(), new Types([\Exception::class])));
        $this->assertEmpty($this->validator->validate(null, new Types([\Exception::class])));
        $this->assertNotEmpty($this->validator->validate(new \RuntimeException(), new Types([\LogicException::class])));
    }
}
