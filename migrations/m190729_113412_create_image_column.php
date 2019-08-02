<?php

use yii\db\Migration;

/**
 * Class m190729_113412_create_image_column
 */
class m190729_113412_create_image_column extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('users', 'image', $this->string());  
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('users', 'image');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190729_113412_create_image_column cannot be reverted.\n";

        return false;
    }
    */
}
