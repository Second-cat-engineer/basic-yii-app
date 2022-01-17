<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%question}}`.
 */
class m211218_125301_create_question_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(
            '{{%question}}',
            [
                'id'            => $this->primaryKey()
                    ->comment('Идентификатор вопроса'),
                'category_id'   => $this->integer()->notNull()
                    ->comment('Идентификатор категории вопроса. category.id'),
                'created_by'    => $this->integer()->notNull()
                    ->comment('Автор вопроса. user.id'),
                'updated_by'    => $this->integer()->notNull()
                    ->comment('Редактор вопроса. user.id'),
                'title'         => $this->string(255)->notNull()
                    ->comment('Заголовок вопроса'),
                'description'   => $this->text()
                    ->comment('Описание вопроса'),
                'status'        => $this->tinyInteger()
                    ->comment('Статус вопроса: 0 - email не подтвержден, 1- email подтвержден, 2 - вопрос решен'),
                'type'          => $this->tinyInteger()
                    ->comment('Тип вопроса: 0 - обычный вопрос, 1 - опрос'),
                'created_at'    => $this->timestamp()
                    ->comment('Дата/время создания'),
                'updated_at'    => $this->timestamp()
                    ->comment('Дата/время редактирование'),
            ],
            "COMMENT 'Таблица для хранения вопросов пользователей'"
        );

        $this->createIndex('idx-question-category_id', '{{%question}}', 'category_id');

        $this->addForeignKey(
            'fk-question-created_by',
            '{{%question}}',
            'created_by',
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
        $this->dropForeignKey('fk-question-created_by', '{{%question}}');
        $this->dropTable('{{%question}}');
    }
}
