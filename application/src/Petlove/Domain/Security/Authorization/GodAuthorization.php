<?php

namespace Petlove\Domain\Security\Authorization;

/**
 * @SuppressWarnings(PHPMD)
 */
class GodAuthorization implements BackendAuthorization
{
    /** @return bool */
    public function canResumeSession()
    {
        return true;
    }

    /**
     * @param mixed $userId
     *
     * @return bool
     */
    public function canLogout($userId)
    {
        ($userId);

        return false;
    }

    public function getUser()
    {
        return;
    }

    /** @return bool */
    public function canLogin()
    {
        return false;
    }

    /** @return bool */
    public function canDeleteBackendUsers()
    {
        return true;
    }

    /** @return bool */
    public function canAccessBackendUsers()
    {
        return true;
    }

    /** @return bool */
    public function canCreateBackendUsers()
    {
        return true;
    }

    /** @return bool */
    public function canUpdateBackendUsers()
    {
        return true;
    }

    /** @return bool */
    public function isAnonymous()
    {
        return false;
    }
}
