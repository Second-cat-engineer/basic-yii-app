<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%question_answer}}`.
 */
class m211218_141041_create_question_answer_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(
            '{{%question_answer}}',
            [
                'id'            => $this->primaryKey()
                    ->comment('Идентификатор ответов на опрос'),
                'question_id'   => $this->integer()
                    ->comment('Идентификатор вопроса. question.id'),
                'answer'        => $this->string(255)->notNull()
                    ->comment('Вариант ответа'),
            ],
            "COMMENT 'Таблица ответов на опрос'"
        );

        $this->createIndex(
            'idx-question_answer-question_id',
            '{{%question_answer}}',
            'question_id'
        );
        $this->addForeignKey(
            'fk-question_answer-question_id',
            '{{%question_answer}}',
            'question_id',
            '{{%question}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-question_answer-question_id', '{{%question_answer}}');
        $this->dropTable('{{%question_answer}}');
    }
}
