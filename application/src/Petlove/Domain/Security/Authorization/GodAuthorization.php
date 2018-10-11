<?php

namespace Petlove\Domain\Security\Authorization;
use Petlove\Domain\BackendUser\Value\BackendUserId;
use Petlove\Domain\Catalog\CatalogAuthorization;

/**
 * Class GodAuthorization
 * @package Petlove\Domain\Security\Authorization
 */
class GodAuthorization implements BackendAuthorization, CatalogAuthorization
{
    public function canResumeSession(): bool
    {
        return true;
    }

    public function canLogout(BackendUserId $userId = null): bool
    {
        ($userId);

        return false;
    }

    public function getUser()
    {
        return;
    }

    public function canLogin(): bool
    {
        return false;
    }

    public function canDeleteBackendUsers(): bool
    {
        return true;
    }

    public function canAccessBackendUsers(): bool
    {
        return true;
    }

    public function canCreateBackendUsers(): bool
    {
        return true;
    }

    public function canUpdateBackendUsers(): bool
    {
        return true;
    }

    public function isAnonymous(): bool
    {
        return false;
    }

    public function canManageCatalog(): bool
    {
        return true;
    }

    public function canAccessCatalog(): bool
    {
        return true;
    }
}
