<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%new_users}}`.
 */
class m250331_135335_create_new_users_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%new_users}}', [
            'id' => $this->primaryKey(),
            'login' => $this->string(255)->notNull()->unique(),
            'password' => $this->string(255)->notNull(),
            'email' => $this->string(255)->notNull()->unique(),
            'image' => $this->text()->defaultValue(null),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('{{%new_users}}');
    }
}
