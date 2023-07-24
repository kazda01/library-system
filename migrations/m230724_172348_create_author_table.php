<?php

use yii\db\Migration;

/**
 * Class m230724_172348_create_author_table
 */
class m230724_172348_create_author_table extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }


        $this->createTable('{{%author}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(191)->notNull(),
            'created_by' => $this->integer()->notNull(),
            'updated_by' => $this->integer()->notNull(),
            'created_at' => $this->timestamp(),
            'updated_at' => $this->timestamp(),
        ], $tableOptions);

        // creates index for column `created_by`
        $this->createIndex(
            '{{%idx-author-created_by}}',
            '{{%author}}',
            'created_by'
        );

        // creates index for column `updated_by`
        $this->createIndex(
            '{{%idx-author-updated_by}}',
            '{{%author}}',
            'updated_by'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-author-created_by}}',
            '{{%author}}',
            'created_by',
            '{{%user}}',
            'id',
            'CASCADE'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-author-updated_by}}',
            '{{%author}}',
            'updated_by',
            '{{%user}}',
            'id',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-author-created_by}}',
            '{{%author}}'
        );

        // drops index for column `created_by`
        $this->dropIndex(
            '{{%idx-author-created_by}}',
            '{{%author}}'
        );
        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-author-updated_by}}',
            '{{%author}}'
        );

        // drops index for column `updated_by`
        $this->dropIndex(
            '{{%idx-author-updated_by}}',
            '{{%author}}'
        );

        $this->dropTable('{{%author}}');
    }
}
