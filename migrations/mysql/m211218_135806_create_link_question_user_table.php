<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%link_question_user}}`.
 */
class m211218_135806_create_link_question_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(
            '{{%link_question_user}}',
            [
                'id' => $this->primaryKey()
                    ->comment('Идентификатор подписки'),
                'user_id' => $this->integer()
                    ->comment('Идентификатор пользователя. user.id'),
                'question_id' => $this->integer()
                    ->comment('Идентификатор вопроса. question.id'),
                'created_at'    => $this->timestamp()
                    ->comment('Дата/время создания'),
            ],
            "COMMENT 'Таблица подписок пользователя на вопросы'"
        );

        $this->createIndex(
            'idx-link_question_user-user_id',
            '{{%link_question_user}}',
            'user_id'
        );
        $this->createIndex(
            'idx-link_question_user-question_id',
            '{{%link_question_user}}',
            'question_id'
        );

        $this->addForeignKey(
            'fk-link_question_user-user_id',
            '{{%link_question_user}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-link_question_user-question_id',
            '{{%link_question_user}}',
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
        $this->dropForeignKey('fk-link_question_user-user_id', '{{%link_question_user}}');
        $this->dropForeignKey('fk-link_question_user-question_id', '{{%link_question_user}}');
        $this->dropTable('{{%link_question_user}}');
    }
}
