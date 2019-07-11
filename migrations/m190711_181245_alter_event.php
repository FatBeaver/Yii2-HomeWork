<?php

use yii\db\Migration;
use app\models\Yii2db;

/**
 * Class m190711_181245_alter_event
 */
class m190711_181245_alter_event extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        return $this->addColumn(Yii2db::tableName(), 'author_id', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        return $this->dropColumn(Yii2db::tableName(), 'author_id');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190711_181245_alter_event cannot be reverted.\n";

        return false;
    }
    */
}
