<?php

namespace Petlove\Infrastructure\BackendUser;

use Util\MySql\Connection;
use Petlove\Domain\BackendUser\BackendUserLightSpecification;
use Petlove\Domain\BackendUser\Value\BackendUserEmail;
use Petlove\Domain\BackendUser\Value\BackendUserId;
use Petlove\Domain\BackendUser\Value\BackendUserUsername;

class MysqlBackendUserLightSpecification implements BackendUserLightSpecification
{
    /**
     * @var Connection
     */
    private $mysql;

    /**
     * MysqlBackendUserRepository constructor.
     *
     * @param Connection $db
     */
    public function __construct(Connection $db)
    {
        $this->mysql = $db;
    }

    /**
     * @param BackendUserEmail $email
     *
     * @return bool
     */
    public function existsByEmail(BackendUserEmail $email)
    {
        return (bool) $this->mysql->bufferedQuery('
          SELECT bu.id FROM backend_users bu WHERE bu.email = ? LIMIT 1
         ', $email)->fetchValue();
    }

    /**
     * @param BackendUserUsername $username
     *
     * @return bool
     */
    public function existsByUsername(BackendUserUsername $username)
    {
        return (bool) $this->mysql->bufferedQuery('
          SELECT bu.id FROM backend_users bu WHERE bu.username = ? LIMIT 1
         ', $username)->fetchValue();
    }

    /**
     * @param BackendUserId $id
     *
     * @return bool
     */
    public function exists(BackendUserId $id)
    {
        return (bool) $this->mysql->bufferedQuery('
          SELECT bu.id FROM backend_users bu WHERE bu.id = ? LIMIT 1
         ', $id)->fetchValue();
    }
}
