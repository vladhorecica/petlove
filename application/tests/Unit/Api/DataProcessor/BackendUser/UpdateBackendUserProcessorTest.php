<?php

namespace Tests\Unit\Api\DataProcessor\BackendUser;

use Petlove\ApiBundle\DataProcessor\BackendUser\UpdateBackendUserProcessor;
use Petlove\Domain\BackendUser\Command\UpdateBackendUser;
use Petlove\Domain\BackendUser\Value\BackendUserId;

/**
 * Class UpdateBackendUserProcessorTest
 * @package Tests\Unit\Api\DataProcessor\BackendUser
 */
class UpdateBackendUserProcessorTest extends \PHPUnit_Framework_TestCase
{
    public function testSuccess()
    {
        $processor = new UpdateBackendUserProcessor(
            new BackendUserId(1)
        );

        $result = $processor([
            "type" => "admin",
            "email" => "test@email.com",
            "username" => "testAdmin"
        ]);

        $this->assertInstanceOf(UpdateBackendUser::class, $result);
    }
}
