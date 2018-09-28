<?php

use Phpmig\Migration\Migration;

class InitialSchema extends Migration
{
    /**
     * Do the migration
     */
    public function up()
    {
        /** @var \Util\MySql\Connection $db */
        $db = $this->container["phpmig.adapter"]->getConnection();

        /**
         * backend users table
         */
        $db->rawQuery("
            CREATE TABLE backend_users (
                id INT UNSIGNED NOT NULL AUTO_INCREMENT,
                email VARCHAR(190) NOT NULL,
                password VARCHAR(100) CHARACTER SET ascii NOT NULL,
                type VARCHAR(32) CHARACTER SET ascii NOT NULL,
                username VARCHAR(190) NOT NULL,
                created_at INT UNSIGNED NULL,
                
                UNIQUE KEY `backend_user_email`(email),
                UNIQUE KEY `backend_user_username`(username),
                
                PRIMARY KEY (id)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
        ");

        /**
         * backend users table
         */
        $db->rawQuery("
            CREATE TABLE catalog_categories (
                id INT UNSIGNED NOT NULL AUTO_INCREMENT,
                name VARCHAR(190) NOT NULL,
                type VARCHAR(32) CHARACTER SET ascii NOT NULL,
                parent_id INT UNSIGNED,
                created_at INT UNSIGNED NULL,

                UNIQUE KEY `catalog_category_name`(name),
                
                FOREIGN KEY (parent_id) REFERENCES catalog_categories(id) ON DELETE SET NULL,
                
                PRIMARY KEY (id)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
        ");
    }

    /**
     * Undo the migration
     */
    public function down()
    {
        /** @var \Util\MySql\Connection $db */
        $db = $this->container["phpmig.adapter"]->getConnection();

        $db->rawQuery("SET FOREIGN_KEY_CHECKS = 0");

        $db->rawQuery("DROP TABLE IF EXISTS backend_users");

        $db->rawQuery("DROP TABLE IF EXISTS catalog_categories");

        $db->rawQuery("SET FOREIGN_KEY_CHECKS = 1");
    }
}
