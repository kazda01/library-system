<?php

use yii\db\Migration;

/**
 * Class m230724_174216_create_book_table
 */
class m230724_174216_create_book_table extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }


        $this->createTable('{{%book}}', [
            'id' => $this->primaryKey(),
            'fk_author' => $this->integer(),
            'name' => $this->string(191)->notNull(),
            'description' => $this->text(),
            'language' => $this->string(32)->notNull(),
            'isbn' => $this->string(13)->notNull(),
            'pages' => $this->integer(),
            'year_of_publication' => $this->integer(4),
            'created_by' => $this->integer()->notNull(),
            'updated_by' => $this->integer()->notNull(),
            'created_at' => $this->timestamp(),
            'updated_at' => $this->timestamp(),
        ], $tableOptions);

        // creates index for column `fk_author`
        $this->createIndex(
            '{{%idx-book-fk_author}}',
            '{{%book}}',
            'fk_author'
        );

        // creates index for column `created_by`
        $this->createIndex(
            '{{%idx-book-created_by}}',
            '{{%book}}',
            'created_by'
        );

        // creates index for column `updated_by`
        $this->createIndex(
            '{{%idx-book-updated_by}}',
            '{{%book}}',
            'updated_by'
        );

        // add foreign key for table `{{%author}}`
        $this->addForeignKey(
            '{{%fk-book-fk_author}}',
            '{{%book}}',
            'fk_author',
            '{{%author}}',
            'id',
            'SET NULL'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-book-created_by}}',
            '{{%book}}',
            'created_by',
            '{{%user}}',
            'id',
            'CASCADE'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-book-updated_by}}',
            '{{%book}}',
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
            '{{%fk-book-created_by}}',
            '{{%book}}'
        );

        // drops index for column `created_by`
        $this->dropIndex(
            '{{%idx-book-created_by}}',
            '{{%book}}'
        );

        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-book-updated_by}}',
            '{{%book}}'
        );

        // drops index for column `updated_by`
        $this->dropIndex(
            '{{%idx-book-updated_by}}',
            '{{%book}}'
        );
        
        // drops foreign key for table `{{%author}}`
        $this->dropForeignKey(
            '{{%fk-book-fk_author}}',
            '{{%book}}'
        );

        // drops index for column `fk_author`
        $this->dropIndex(
            '{{%idx-book-fk_author}}',
            '{{%book}}'
        );

        $this->dropTable('{{%book}}');
    }
}
