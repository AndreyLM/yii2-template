<?php

use yii\db\Migration;

/**
 * Class m171120_111712_create_article
 */
class m171120_111712_create_article extends Migration
{

    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%article}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(256)->notNull(),
            'slug' => $this->string(256)->notNull(),
            'category_id' => $this->integer()->unsigned(),
            'user_id' => $this->integer()->unsigned(),
            'author' => $this->string(64)->null(),

            'text_intro' => $this->string()->notNull(),
            'text_body' => $this->string()->null(),
            'text_body_markdown' => $this->string()->null(),
            'meta_json' => 'JSON',
            'status' => $this->integer(1)->defaultValue(0),
            'favorite' => $this->integer(1)->defaultValue(0),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'publishing_at' => $this->integer()
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%article}}');
    }

}
