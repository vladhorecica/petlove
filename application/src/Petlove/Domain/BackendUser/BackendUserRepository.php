<?php

namespace Petlove\Domain\BackendUser;

use Util\Value\Page;
use Petlove\Domain\BackendUser\Command\CreateBackendUser;
use Petlove\Domain\BackendUser\Command\UpdateBackendUser;
use Petlove\Domain\BackendUser\Value\BackendUserId;
use Petlove\Domain\Common\Query\Result;

/**
 * Interface BackendUserRepository
 * @package Petlove\Domain\BackendUser
 */
interface BackendUserRepository
{
    public function create(CreateBackendUser $cmd): BackendUserId;

    public function update(UpdateBackendUser $cmd);

    public function delete(BackendUserId $id);

    public function find(BackendUserId $id): BackendUser;

    /**
     * @param mixed     $filter
     * @param Page|null $page
     *
     * @return BackendUser[]|Result
     */
    public function query($filter = null, Page $page = null);
}
