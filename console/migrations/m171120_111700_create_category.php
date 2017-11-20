<?php

use yii\db\Migration;

/**
 * Class m171120_111700_create_category
 */
class m171120_111700_create_category extends Migration
{
    public function up()
    {

        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%category}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'name' => $this->string(32)->notNull()->unique(),
            'description' => $this->string(),
            'meta_json' => 'JSON',
            'depth' => $this->integer(1)->notNull(),
            'rgt' => $this->integer(4)->notNull(),
            'lft' => $this->integer(4)->notNull()
        ], $tableOptions);

        $this->insert('{{%category}}', [
            'id' => 1,
            'title' => 'root',
            'name' => 'root',
            'description' => 'Root category',
            'meta_json' => '{}',
            'depth' => 0,
            'lft' => 1,
            'rgt' => 2
        ]);
    }

    public function down()
    {
        $this->dropTable('{{%category}}');
    }
}
