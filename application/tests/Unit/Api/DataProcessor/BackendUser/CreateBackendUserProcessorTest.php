<?php

namespace Tests\Unit\Api\DataProcessor\BackendUser;

use Petlove\ApiBundle\DataProcessor\BackendUser\CreateBackendUserProcessor;
use Petlove\Domain\BackendUser\Command\CreateBackendUser;

/**
 * Class CreateBackendUserProcessorTest
 * @package Tests\Unit\Api\DataProcessor\BackendUser
 */
class CreateBackendUserProcessorTest extends \PHPUnit_Framework_TestCase
{
    public function testSuccess()
    {
        $processor = new CreateBackendUserProcessor();

        $result = $processor([
            "type"     => "admin",
            "email"    => "test@email.com",
            "password" => "testPassword123",
            "username" => "testAdmin"
        ]);
        $this->assertInstanceOf(CreateBackendUser::class, $result);
    }
}
