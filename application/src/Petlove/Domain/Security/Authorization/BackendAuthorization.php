<?php

namespace Petlove\Domain\Security\Authorization;

/**
 * Interface BackendAuthorization
 * @package Petlove\Domain\Security\Authorization
 */
interface BackendAuthorization extends Authorization
{
    public function canDeleteBackendUsers(): bool;

    public function canAccessBackendUsers(): bool;

    public function canCreateBackendUsers(): bool;

    public function canUpdateBackendUsers(): bool;
}
