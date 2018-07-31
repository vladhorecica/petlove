<?php

use Phpmig\Migration\Migration;

class Init extends Migration
{
    /**
     * Do the migration
     */
    public function up()
    {
        /** @var \Util\MySql\Connection $db */
        $db = $this->container["phpmig.adapter"]->getConnection();

        $database = $db->bufferedQuery("SELECT DATABASE()")->fetchValue();
        $db->rawQuery("
            ALTER DATABASE `$database`
                DEFAULT CHARACTER SET utf8mb4
                DEFAULT COLLATE utf8mb4_general_ci
        ");
    }

    /**
     * Undo the migration
     */
    public function down()
    {
        //
    }
}
