<?php

namespace Petlove\Domain\BackendUser;

use Petlove\Domain\BackendUser\Value\BackendUserEmail;
use Petlove\Domain\BackendUser\Value\BackendUserId;
use Petlove\Domain\BackendUser\Value\BackendUserUsername;

interface BackendUserLightSpecification
{
    /**
     * @param BackendUserEmail $email
     *
     * @return bool
     */
    public function existsByEmail(BackendUserEmail $email);

    /**
     * @param BackendUserUsername $username
     *
     * @return bool
     */
    public function existsByUsername(BackendUserUsername $username);

    /**
     * @param BackendUserId $id
     *
     * @return bool
     */
    public function exists(BackendUserId $id);
}
