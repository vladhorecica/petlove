<?php
/*
 * migration bootstrap that will only deal with the master database;
 * Use ./bin/console for migrations instead
 * Use this to generate new migration files
 */

use Phpmig\Adapter;

require 'app/CliKernel.php';

$kernel = new Base\CliKernel('dev', true);
$kernel->boot();

$container = new ArrayObject();
$container['phpmig.migrations_path'] = __DIR__.'/migrations/master';
$container['mysql_connection'] = $kernel->getContainer()->get('mysql_connection');
$container['phpmig.adapter'] = new Adapter\PDO\Sql(
    new \PDO(
        sprintf(
            'mysql:dbname=%s;host=%s',
            $kernel->getContainer()->getParameter('database_name'),
            $kernel->getContainer()->getParameter('database_host')
        ),
        $kernel->getContainer()->getParameter('database_user'),
        $kernel->getContainer()->getParameter('database_password')
    ),
    'migrations'
);

return $container;
