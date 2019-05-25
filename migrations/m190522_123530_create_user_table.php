<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user}}`.
 */
class m190522_123530_create_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'mobileNumber' => $this->string(20)->notNull()->unique(),
            'firstName' => $this->string(50)->notNull(),
            'lastName' => $this->string(50)->notNull(),
            'dateOfBirth' => $this->date(),
            'gender' => $this->tinyInteger(),
            'email' => $this->string(50)->notNull()->unique(),
            'password' => $this->string(255)->notNull(),
            'authKey' => $this->string(255)->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user}}');
    }
}
