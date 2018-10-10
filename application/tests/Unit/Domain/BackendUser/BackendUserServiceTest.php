<?php

namespace Tests\Unit\Domain\BackendUser;

use Petlove\Domain\BackendUser\BackendUserRepository;
use Petlove\Domain\BackendUser\BackendUserService;
use Petlove\Domain\BackendUser\Command\CreateBackendUser;
use Petlove\Domain\BackendUser\Value\BackendUserEmail;
use Petlove\Domain\BackendUser\Value\BackendUserId;
use Petlove\Domain\BackendUser\Value\BackendUserType;
use Petlove\Domain\BackendUser\Value\BackendUserUsername;
use Petlove\Domain\Security\Authorization\AdminAuthorization;
use Petlove\Domain\Security\Authorization\AnonymousAuthorization;
use Petlove\Domain\Security\Exception\AuthenticationError;
use Petlove\Domain\Security\Exception\AuthorizationError;
use Symfony\Component\Validator\Validator\RecursiveValidator;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Tests\Unit\GenericTestCase;

/**
 * Class UpdateBackendUserServiceTest
 * @package Tests\Unit\Domain\BackendUser
 */
class UpdateBackendUserServiceTest extends GenericTestCase
{
    /** @var ValidatorInterface */
    private $validator;

    /** @var BackendUserRepository */
    private $repoMock;

    /** @var BackendUserService */
    private $service;

    public function setUp()
    {
        $this->repoMock = $this->createMock(BackendUserRepository::class);
        $this->validator = $this->createMock(RecursiveValidator::class);

        $this->service = new BackendUserService(
            $this->repoMock,
            $this->validator
        );

        parent::setUp();
    }

    public function testCreateSuccess()
    {
        $userId = new BackendUserId(1);

        $cmd = new CreateBackendUser(
            new BackendUserEmail('test@test.com'),
            new BackendUserUsername('test'),
            'somePassword123',
            BackendUserType::admin()
        );

        $authorization = $this->createMock(AdminAuthorization::class);

        $authorization->expects($this->once())
            ->method('isAnonymous')
            ->willReturn(false);

        $authorization->expects($this->once())
            ->method('canCreateBackendUsers')
            ->willReturn(true);

        $this->repoMock->expects($this->once())
            ->method('create')
            ->willReturn($userId);

        $this->validator->expects($this->once())
            ->method('validate')
            ->with($cmd)
            ->willReturn([]);

        $result = $this->service->create($authorization, $cmd);

        $this->assertEquals($result, $userId);
    }

    /**
     * @expectedException AuthenticationError
     */
    public function testCreateAuthenticationFails()
    {
        $cmd = new CreateBackendUser(
            new BackendUserEmail('test@test.com'),
            new BackendUserUsername('test'),
            'somePassword123',
            BackendUserType::admin()
        );

        $authorization = new AnonymousAuthorization();

        $this->expectException(AuthenticationError::class);

        $this->service->create($authorization, $cmd);
    }

    /**
     * @expectedException AuthorizationError
     */
    public function testCreateAuthorizationFails()
    {
        $cmd = new CreateBackendUser(
            new BackendUserEmail('test@test.com'),
            new BackendUserUsername('test'),
            'somePassword123',
            BackendUserType::admin()
        );

        $authorization = $this->createMock(AdminAuthorization::class);

        $authorization->expects($this->once())
            ->method('isAnonymous')
            ->willReturn(false);

        $authorization->expects($this->once())
            ->method('canCreateBackendUsers')
            ->willReturn(false);

        $this->expectException(AuthorizationError::class);

        $this->service->create($authorization, $cmd);
    }
}
