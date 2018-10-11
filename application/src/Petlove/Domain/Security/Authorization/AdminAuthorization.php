<?php

namespace Petlove\Domain\Security\Authorization;

use Petlove\Domain\BackendUser\BackendUser;
use Petlove\Domain\BackendUser\Value\BackendUserId;
use Petlove\Domain\Catalog\CatalogAuthorization;

/**
 * Class AdminAuthorization
 * @package Petlove\Domain\Security\Authorization
 */
class AdminAuthorization implements BackendAuthorization, CatalogAuthorization
{
    /** @var BackendUser */
    private $backendUser;

    /**
     * AdminAuthorization constructor.
     *
     * @param BackendUser $backendUser
     */
    public function __construct(BackendUser $backendUser)
    {
        $this->backendUser = $backendUser;
    }

    public function getUser(): BackendUser
    {
        return $this->backendUser;
    }

    public function canResumeSession(): bool
    {
        return true;
    }

    public function canLogout(BackendUserId $backendUserId): bool
    {
        if (!$backendUserId instanceof BackendUserId) {
            throw new \InvalidArgumentException();
        }

        return $this->isMe($backendUserId);
    }

    private function isMe(BackendUserId $user = null): bool
    {
        return $this->backendUser->getId()->equals($user);
    }

    public function canLogin(): bool
    {
        return true;
    }

    public function canDeleteBackendUsers(): bool
    {
        return true;
    }

    public function canAccessBackendUsers(): bool
    {
        return true;
    }

    public function canManageCatalog(): bool
    {
        return true;
    }

    public function canAccessCatalog(): bool
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
}
