<?php

namespace Petlove\Domain\Security\Authorization;

use Petlove\Domain\BackendUser\BackendUser;
use Petlove\Domain\BackendUser\Value\BackendUserId;

interface Authorization
{
    /**
     * @return BackendUser|null
     */
    public function getUser();

    /** @return bool */
    public function canResumeSession();

    /** @return bool */
    public function canLogin();

    /**
     * @param BackendUserId $userId
     *
     * @return bool
     */
    public function canLogout($userId);

    /** @return bool */
    public function isAnonymous();
}
