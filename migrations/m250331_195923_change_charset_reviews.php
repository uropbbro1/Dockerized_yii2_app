<?php

use yii\db\Migration;

class m250331_195923_change_charset_reviews extends Migration
{
    public function up()
    {
        $this->execute("ALTER TABLE `reviews` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;");
    }

    public function down()
    {
        $this->execute("ALTER TABLE `reviews` CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;");
    }
}
