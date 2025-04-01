<?php

use yii\db\Migration;

class m250331_204851_insert_column_new_user extends Migration
{

    public function safeUp()
    {
        $this->execute('ALTER TABLE new_users ADD COLUMN auth_key VARCHAR(255) NOT NULL;');
    }

    public function safeDown()
    {
        echo "m250331_204851_insert_column_new_user cannot be reverted.\n";

        return false;
    }

}
