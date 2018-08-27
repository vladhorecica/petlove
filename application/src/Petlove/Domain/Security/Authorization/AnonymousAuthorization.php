<?php

namespace Petlove\Domain\Security\Authorization;

use Petlove\Domain\BackendUser\Value\BackendUserId;

/**
 * @SuppressWarnings(PHPMD)
 */
class AnonymousAuthorization implements BackendAuthorization
{
    public function getUser()
    {
        return;
    }

    /**
     * @return bool
     */
    public function canResumeSession()
    {
        return false;
    }



    /**
     * @return bool
     */
    public function canLogin()
    {
        return true;
    }

    /**
     * @param BackendUserId $userId
     *
     * @return bool
     */
    public function canLogout($userId)
    {
        ($userId);

        return false;
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
    public function isAnonymous()
    {
        return true;
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
}
