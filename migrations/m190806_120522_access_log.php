<?php

use yii\db\Migration;

/**
 * Class m190806_120522_access_log
 */
class m190806_120522_access_log extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('access_log', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'access_date' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP')
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('access_log');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190806_120522_access_log cannot be reverted.\n";

        return false;
    }
    */
}
