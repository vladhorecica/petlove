<?php

namespace Petlove\Domain\Security\Authorization;

use Petlove\Domain\BackendUser\BackendUser;
use Petlove\Domain\BackendUser\Value\BackendUserId;

/**
 * @SuppressWarnings(PHPMD)
 */
class AdminAuthorization implements BackendAuthorization
{
    /**
     * @var BackendUser
     */
    private $backendUser;

    /**
     * SuperAdminAuthorization constructor.
     *
     * @param BackendUser $backendUser
     */
    public function __construct(BackendUser $backendUser)
    {
        $this->backendUser = $backendUser;
    }

    /**
     * @return BackendUser
     */
    public function getUser()
    {
        return $this->backendUser;
    }

    /**
     * @return bool
     */
    public function canResumeSession()
    {
        return true;
    }

    /**
     * @param BackendUserId $backendUserId
     *
     * @return bool
     */
    public function canLogout($backendUserId)
    {
        if (!$backendUserId instanceof BackendUserId) {
            throw new \InvalidArgumentException();
        }

        return $this->isMe($backendUserId);
    }

    /**
     * @param BackendUserId|null $user
     *
     * @return bool
     */
    private function isMe(BackendUserId $user = null)
    {
        return $this->backendUser->getId()->equals($user);
    }

    /**
     * @return bool
     */
    public function canLogin()
    {
        return true;
    }

    /**
     * @return bool
     */
    public function canDeleteBackendUsers()
    {
        return false;
    }

    /**
     * @return bool
     */
    public function canAccessBackendUsers()
    {
        return false;
    }

    /**
     * @return bool
     */
    public function canCreateBackendUsers()
    {
        return false;
    }

    /**
     * @return bool
     */
    public function canUpdateBackendUsers()
    {
        return false;
    }

    /**
     * @return bool
     */
    public function isAnonymous()
    {
        return false;
    }
}
