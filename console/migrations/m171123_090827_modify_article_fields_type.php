<?php

use yii\db\Migration;

/**
 * Class m171123_090827_modify_article_fields_type
 */
class m171123_090827_modify_article_fields_type extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->alterColumn('{{%article}}', 'text_intro', $this->text());
        $this->alterColumn('{{%article}}', 'text_body', $this->text());
        $this->alterColumn('{{%article}}', 'text_body_markdown', $this->text());
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
        echo "m171123_090827_modify_article_fields_type cannot be reverted.\n";

        return false;
    }
    */
}
