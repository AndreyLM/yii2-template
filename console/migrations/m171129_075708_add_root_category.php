<?php

use yii\db\Migration;

/**
 * Class m171129_075708_add_root_category
 */
class m171129_075708_add_root_category extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->insert('{{%menu}}', [
            'id' => 1,
            'title' => 'root',
            'name' => 'root',
            'description' => 'Root menu',
            'status' => 1,
            'depth' => 0,
            'lft' => 1,
            'rgt' => 2
        ]);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {

    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171129_075708_add_root_category cannot be reverted.\n";

        return false;
    }
    */
}
