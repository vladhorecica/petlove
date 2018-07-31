<?php

namespace Petlove\Infrastructure\Common;

use Util\MySql\Connection;
use Util\MySql\Error;
use Phpmig\Adapter\AdapterInterface;
use Phpmig\Migration\Migration;

class MysqliAdapter implements AdapterInterface
{
    /**
     * @var Connection
     */
    private $connection;

    /**
     * @var string
     */
    private $tableName;

    /**
     * MysqliAdapter constructor.
     *
     * @param Connection $connection
     * @param string     $tableName
     */
    public function __construct(Connection $connection, $tableName)
    {
        $this->connection = $connection;
        $this->tableName = $tableName;
    }

    /**
     * @return \mixed[]
     */
    public function fetchAll()
    {
        return array_map(function ($version) {
            return $version['migrations.version'];
        }, $this->connection->bufferedQuery(
            "SELECT `version` FROM {$this->quotedTableName()} ORDER BY `version` ASC"
        )->toArray());
    }

    /**
     * @param Migration $migration
     *
     * @return $this
     */
    public function up(Migration $migration)
    {
        $this->connection->commandQuery(
            "INSERT into {$this->quotedTableName()} set version = ?",
            $migration->getVersion()
        );

        return $this;
    }

    /**
     * @param Migration $migration
     *
     * @return $this
     */
    public function down(Migration $migration)
    {
        $this->connection->commandQuery(
            "DELETE from {$this->quotedTableName()} where version = ?",
            $migration->getVersion()
        );

        return $this;
    }

    /**
     * @return bool
     */
    public function hasSchema()
    {
        try {
            $this->connection->commandQuery("SELECT 1 FROM {$this->quotedTableName()} LIMIT 1;");

            return true;
        } catch (Error $error) {
            return false;
        }
    }

    /**
     * @return $this
     */
    public function createSchema()
    {
        $this->connection->commandQuery(
            "CREATE TABLE {$this->quotedTableName()} (`version` VARCHAR(255) NOT NULL);"
        );

        return $this;
    }

    /**
     * @return Connection
     */
    public function getConnection()
    {
        return $this->connection;
    }

    /**
     * @return $this
     */
    public function closeConnection()
    {
        $this->connection->close();

        return $this;
    }

    /**
     * @return string
     */
    private function quotedTableName()
    {
        return "`{$this->tableName}`";
    }
}
