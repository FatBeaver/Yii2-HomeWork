<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%calendar}}`.
 */
class m190728_204903_create_calendar_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('calendar', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'content' => $this->string(),
            'date_of_create' => $this->datetime(),
            'date_of_change' => $this->datetime()->defaultValue(time()),
            'expiration_date' => $this->datetime(),
            'author_id' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('calendar');
    }
}
