<?php

namespace Petlove\Domain\BackendUser;

use Util\Value\Page;
use Petlove\Domain\BackendUser\Command\CreateBackendUser;
use Petlove\Domain\BackendUser\Command\UpdateBackendUser;
use Petlove\Domain\BackendUser\Value\BackendUserId;
use Petlove\Domain\Common\Query\Result;

interface BackendUserRepository
{
    /**
     * @param CreateBackendUser $cmd
     *
     * @return BackendUserId
     */
    public function create(CreateBackendUser $cmd);

    /**
     * @param UpdateBackendUser $cmd
     */
    public function update(UpdateBackendUser $cmd);

    /**
     * @param BackendUserId $id
     */
    public function delete(BackendUserId $id);

    /**
     * @param BackendUserId $id
     *
     * @return BackendUser
     */
    public function get(BackendUserId $id);

    /**
     * @param mixed     $filter
     * @param Page|null $page
     *
     * @return BackendUser[]|Result
     */
    public function query($filter = null, Page $page = null);
}
