<?php

use yii\db\Migration;

class m250331_200423_insert_new_user extends Migration
{
    public function safeUp()
    {
        $this->insert('{{%new_users}}', [
            'login' => 'Гость',
            'email' => 'guest@mail.ru',
            'password' => 'guest',
            'image' => ''
        ]);
    }

    public function safeDown()
    {
        echo "m250331_195223_insert_user cannot be reverted.\n";

        return false;
    }
}
