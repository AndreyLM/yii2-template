<?php

use yii\db\Migration;

/**
 * Class m171201_084946_create_gallery
 */
class m171201_084946_create_gallery extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        $this->createTable('{{%gallery}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(128)->notNull(),
            'name' => $this->string(192)->notNull()
        ], $tableOptions);

        $this->createTable('{{%photo}}', [
            'id' => $this->primaryKey(),
            'gallery_id' => $this->integer()->notNull(),
            'file' => $this->string()->notNull(),
            'sort' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createIndex('{{%idx-photo-gallery_id}}', '{{%photo}}', 'gallery_id');
        $this->addForeignKey('{{%fk-photo-gallery_id}}', '{{%photo}}', 'gallery_id',
            '{{%gallery}}', 'id', 'CASCADE', 'RESTRICT');
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('{{%photo}}');
        $this->dropTable('{{%gallery}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171201_084946_create_gallery cannot be reverted.\n";

        return false;
    }
    */
}
