<?php

namespace Petlove\Infrastructure\Common;

use Util\MySql\Connection;
use Petlove\Infrastructure\Common\Value\DatabaseType;
use Phpmig\Api\PhpmigApplication;
use Symfony\Component\Console\Output\OutputInterface;

class MigrationService
{
    const MIGRATIONS_TABLE = 'migrations';

    /**
     * @var string
     */
    private $kernelRootDir;

    /**
     * @var Connection
     */
    private $masterConnection;

    /**
     * MigrationService constructor.
     *
     * @param string                       $kernelRootDir
     * @param Connection                   $mainConnection
     */
    public function __construct(
        $kernelRootDir,
        Connection $mainConnection
    ) {
        $this->kernelRootDir = $kernelRootDir;
        $this->masterConnection = $mainConnection;
    }

    /**
     * @param OutputInterface $output
     *
     * @return $this
     * @throws \Exception
     */
    public function migrateMaster(OutputInterface $output)
    {
        $app = $this->buildPhpmigApplication(DatabaseType::master(), $output);
        $app->up();

        return $this;
    }

    /**
     * @param OutputInterface $output
     *
     * @return $this
     * @throws \Exception
     */
    public function rollbackMaster(OutputInterface $output)
    {
        $app = $this->buildPhpmigApplication(DatabaseType::master(), $output);
        $app->down();

        return $this;
    }


    /**
     * @param DatabaseType $databaseType
     * @param OutputInterface $output
     *
     * @return PhpmigApplication
     * @throws \Exception
     */
    private function buildPhpmigApplication(DatabaseType $databaseType, OutputInterface $output)
    {
        $container = new \ArrayObject();
        $container['phpmig.migrations_path'] = $this->getMigrationsPath($databaseType);
        $container['phpmig.adapter'] = $this->getAdapter($databaseType);

        return new PhpmigApplication($container, $output);
    }

    /**
     * @param DatabaseType $databaseType
     *
     * @return MysqliAdapter
     * @throws \Exception
     */
    private function getAdapter(DatabaseType $databaseType)
    {
        if ($databaseType->equals(DatabaseType::master())) {
            return new MysqliAdapter($this->masterConnection, self::MIGRATIONS_TABLE);
        }

        throw new \Exception('No database type specified.');
    }

    /**
     * @param DatabaseType $databaseType
     * @return string
     * @throws \Exception
     */
    private function getMigrationsPath(DatabaseType $databaseType)
    {
        if ($databaseType->equals(DatabaseType::master())) {
            return $this->kernelRootDir.'/../migrations/master';
        }

        throw new \Exception('No database type specified.');
    }
}
