<?php

use yii\db\Migration;

/**
 * Class m171120_111722_create_menu
 */
class m171120_111722_create_menu extends Migration
{

    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%menu}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'name' => $this->string(32)->notNull()->unique(),
            'description' => $this->string(),
            'img' => $this->string(),
            'type' => $this->integer(),
            'relation' => $this->integer(),
            'depth' => $this->integer(1)->notNull(),
            'rgt' => $this->integer(4)->notNull(),
            'lft' => $this->integer(4)->notNull()
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%menu}}');
    }

}
