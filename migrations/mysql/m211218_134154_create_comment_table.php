<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%comment}}`.
 */
class m211218_134154_create_comment_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(
            '{{%comment}}',
            [
                'id'            => $this->primaryKey()
                    ->comment('Идентификатор комментария'),
                'parent_id'     => $this->integer()
                    ->comment('Идентификтор родительского комментария'),
                'question_id'   => $this->integer()
                    ->comment('Идентификатор вопроса'),
                'created_by'    => $this->integer()->notNull()
                    ->comment('Автор комментария. user.id'),
                'updated_by'    => $this->integer()->notNull()
                    ->comment('Редактор комментария. user.id'),
                'comment' => $this->text()
                    ->comment('Текст комментария'),
                'created_at'    => $this->timestamp()
                    ->comment('Дата/время создания'),
                'updated_at'    => $this->timestamp()
                    ->comment('Дата/время редактирование'),
            ],
            "COMMENT 'Таблица комментариев'"
        );

        $this->createIndex('idx-comment-parent_id', '{{%comment}}', 'parent_id');
        $this->createIndex('idx-comment-question_id', '{{%comment}}', 'question_id');

        $this->addForeignKey(
            'fk-comment-question_id',
            '{{%comment}}',
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
        $this->dropForeignKey('fk-comment-question_id', '{{%comment}}');
        $this->dropTable('{{%comment}}');
    }
}
