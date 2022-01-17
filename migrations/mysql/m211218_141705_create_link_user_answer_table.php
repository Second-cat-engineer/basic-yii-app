<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%link_user_answer}}`.
 */
class m211218_141705_create_link_user_answer_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(
            '{{%link_user_answer}}',
            [
                'id'                    => $this->primaryKey()
                    ->comment('Идентификатор ответа пользователя на опрос'),
                'user_id'               => $this->integer()
                    ->comment('Идентификатор пользователя. user.id'),
                'question_answer_id'    => $this->integer()
                    ->comment('Идентификатор ответа опроса. question_answer.id'),
                'created_at'            => $this->timestamp()
                    ->comment('Дата/время создания'),
            ],
            "COMMENT 'Таблица ответов пользователя на опрос'"
        );

        $this->addForeignKey(
            'fk-link_user_answer-question_answer_id',
            '{{%link_user_answer}}',
            'question_answer_id',
            '{{%question_answer}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-link_user_answer-question_answer_id', '{{%link_user_answer}}');
        $this->dropTable('{{%link_user_answer}}');
    }
}
