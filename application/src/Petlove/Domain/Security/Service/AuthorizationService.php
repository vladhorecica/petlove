<?php

namespace Petlove\Domain\Security\Service;

use Petlove\Domain\BackendUser\BackendUser;
use Petlove\Domain\BackendUser\Value\BackendUserType;
use Petlove\Domain\Common\Exception\NotImplementedError;
use Petlove\Domain\Security\Authorization\AdminAuthorization;

class AuthorizationService
{
    /**
     * @param BackendUser $backendUser
     *
     * @return AdminAuthorization
     */
    public function createBackendUserAuthorization(BackendUser $backendUser)
    {
        if ($backendUser->getType()->equals(BackendUserType::admin())) {
            return new AdminAuthorization($backendUser);
        }

        throw new NotImplementedError("Cannot create authorization for user type {$backendUser->getType()->getValue()}");
    }
}
