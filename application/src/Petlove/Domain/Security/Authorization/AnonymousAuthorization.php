<?php

namespace Petlove\Domain\Security\Authorization;

use Petlove\Domain\BackendUser\Value\BackendUserId;
use Petlove\Domain\Catalog\CatalogAuthorization;

/**
 * Class AnonymousAuthorization
 * @package Petlove\Domain\Security\Authorization
 */
class AnonymousAuthorization implements BackendAuthorization, CatalogAuthorization
{
    public function getUser()
    {
        return;
    }

    public function canResumeSession(): bool
    {
        return false;
    }

    public function canManageCatalog(): bool
    {
        return false;
    }

    public function canAccessCatalog(): bool
    {
        return true;
    }

    public function canLogin(): bool
    {
        return true;
    }

    public function canLogout(BackendUserId $userId): bool
    {
        ($userId);

        return false;
    }

    public function canDeleteBackendUsers(): bool
    {
        return false;
    }

    public function isAnonymous(): bool
    {
        return true;
    }

    public function canAccessBackendUsers(): bool
    {
        return false;
    }

    public function canCreateBackendUsers(): bool
    {
        return false;
    }

    public function canUpdateBackendUsers(): bool
    {
        return false;
    }
}
