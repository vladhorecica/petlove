<?php

namespace Petlove\Domain\Security\Authorization;

use Petlove\Domain\BackendUser\BackendUser;
use Petlove\Domain\BackendUser\Value\BackendUserId;

/**
 * Interface Authorization
 * @package Petlove\Domain\Security\Authorization
 */
interface Authorization
{
    /**
     * @return BackendUser|null
     */
    public function getUser();

    public function canResumeSession(): bool;

    public function canLogin(): bool;

    public function canLogout(BackendUserId $userId): bool;

    public function isAnonymous(): bool;
}
