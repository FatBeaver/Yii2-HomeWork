<?php

use yii\db\Migration;

/**
 * Class m190718_144533_access_table
 */
class m190718_144533_access_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('access', [
            'id'        =>  $this->primaryKey(),
            'note_id' =>  $this->integer()->notNull(),
            'user_id'   =>  $this->integer()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       $this->dropTable('access');
    }
}
