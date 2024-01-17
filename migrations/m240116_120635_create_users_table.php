<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%users}}`.
 */
class m240116_120635_create_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%users}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(64),
            'email' => $this->string(64)->notNull()->unique(),
            'password' => $this->string(120),
            'auth_key' =>  $this->string(100),
            'role' => $this->string(60)->defaultValue('user'),
            'created_at' => $this->dateTime()->defaultValue(Date('Y-m-d H:i:s')),
            'updated_at' => $this->dateTime()->defaultValue(Date('Y-m-d H:i:s')),
        ]);

        $time = time();
        $password_hash = Yii::$app->getSecurity()->generatePasswordHash('welcome');
        $auth_key = Yii::$app->security->generateRandomString();

        //add profile entry for admin
        $this->insert('users',
            [
                'name' => "Admin",
                'email' => 'admin@toxsl.com',
                'password' => $password_hash,
                'auth_key' => $auth_key,
                'role' => 'admin',
            ]
        );
        $this->insert('users',
            [
                'name' => "Manager",
                'email' => 'manager@toxsl.com',
                'password' => $password_hash,
                'auth_key' => $auth_key,
                'role' => 'manager',
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%users}}');
    }
}
