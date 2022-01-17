<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user}}`.
 */
class m211218_122126_create_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(
            '{{%user}}',
            [
                'id'            => $this->primaryKey()
                    ->comment('Идентификатор пользователя'),
                'login'         => $this->string(100)->unique()->notNull()
                    ->comment('Логин пользователя'),
                'email'         => $this->string(100)->unique()->notNull()
                    ->comment('email пользователя'),
                'password_hash' => $this->string(255)
                    ->comment('хэш пароля пользователя'),
                'access_token'  => $this->string(512)
                    ->comment('токен'),
                'status'        => $this->smallInteger()->notNull()->defaultValue(0)
                    ->comment('Статус: 0 - email не подтвержден, 1- email подтвержден, 2 - пользователь удален'),
                'created_at'    => $this->timestamp()
                    ->comment('Дата/время создания'),
            ],
            "COMMENT 'Таблица для хранения информации пользователя'"
        );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user}}');
    }
}
