<?php

use yii\db\Migration;

/**
 * Class m171120_115729_add_field_status_category_menu
 */
class m171120_115729_add_field_status_category_menu extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->addColumn('{{%category}}', 'status',
            $this->integer(1)->defaultValue(0));
        $this->addColumn('{{%menu}}', 'status',
            $this->integer(1)->defaultValue(0));
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropColumn('{{%category}}', 'status');
        $this->dropColumn('{{%menu}}', 'status');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171120_115729_add_field_status_category_menu cannot be reverted.\n";

        return false;
    }
    */
}
