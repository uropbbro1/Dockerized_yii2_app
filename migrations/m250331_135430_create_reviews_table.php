<?php

use yii\db\Migration;

class m250331_135430_create_reviews_table extends Migration
{
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable('{{%reviews}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'title' => $this->string()->notNull(),
            'is_recommended' => $this->string(),
            'text' => $this->text()->notNull(),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
        ], $tableOptions);

        $this->createIndex(
            'idx-reviews-user_id',
            '{{%reviews}}',
            'user_id'
        );

        $this->addForeignKey(
            'fk-reviews-user_id',
            '{{%reviews}}',
            'user_id',
            '{{%new_users}}',
            'id',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropTable('{{%reviews}}');
    }
}
