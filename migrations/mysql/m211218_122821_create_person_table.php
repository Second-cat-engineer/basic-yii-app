<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%person}}`.
 */
class m211218_122821_create_person_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(
            '{{%person}}',
            [
                'id'            => $this->primaryKey()
                    ->comment('Идентификатор профиля'),
                'user_id'       => $this->integer()->notNull()
                    ->comment('Идентификатор пользователя. user.id'),
                'first_name'    => $this->string(255)
                    ->comment('Имя профиля'),
                'last_name'     => $this->string(255)
                    ->comment('Фамилия профиля'),
                'gender'        => $this->boolean()
                    ->comment('Пол профиля: 0 - жен, 1 - муж'),
                'birthday'      => $this->timestamp()
                    ->comment('День рождение профиля'),
                'city'          => $this->string(100)
                    ->comment('Город профиля'),
                'created_at'    => $this->timestamp()
                    ->comment('Дата/время создания'),
                'updated_at'    => $this->timestamp()
                    ->comment('Дата/время редактирование'),
            ],
        "COMMENT 'Таблица для хранения информации профиля'"
        );

        $this->createIndex('idx-person-user_id', '{{%person}}', 'user_id');

        $this->addForeignKey(
            'fk-person-user_id',
            '{{%person}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-person-user_id', '{{%person}}');
        $this->dropTable('{{%person}}');
    }
}
