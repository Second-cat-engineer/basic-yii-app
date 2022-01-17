<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%category}}`.
 */
class m211218_133443_create_category_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(
            '{{%category}}',
            [
            'id' => $this->primaryKey()->comment('Идентификатор категории'),
            'name' => $this->string(255)->comment('Название категории'),
            ],
            "COMMENT 'Таблица категорий'"
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%category}}');
    }
}
