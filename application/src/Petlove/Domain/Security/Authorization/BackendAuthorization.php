<?php

namespace Petlove\Domain\Security\Authorization;

interface BackendAuthorization extends Authorization
{
    /** @return bool */
    public function canDeleteBackendUsers();

    /** @return bool */
    public function canAccessBackendUsers();

    /** @return bool */
    public function canCreateBackendUsers();

    /** @return bool */
    public function canUpdateBackendUsers();
}
