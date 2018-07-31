<?php

namespace Petlove\Infrastructure\BackendUser;

use Petlove\Domain\BackendUser\BackendUser;
use Petlove\Domain\BackendUser\Value\BackendUserEmail;
use Petlove\Domain\BackendUser\Value\BackendUserId;
use Petlove\Domain\BackendUser\Value\BackendUserType;
use Petlove\Domain\BackendUser\Value\BackendUserUsername;

class BackendUserMysqlToDomainMapper
{
    /**
     * @param array             $data
     *
     * @return BackendUser
     */
    public function map(array $data)
    {
        return new BackendUser(
            new BackendUserId($data['bu.id']),
            new BackendUserUsername($data['bu.username']),
            new BackendUserEmail($data['bu.email']),
            $data['bu.password'],
            new BackendUserType($data['bu.type'])
        );
    }
}
