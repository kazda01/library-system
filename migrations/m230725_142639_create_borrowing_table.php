<?php

use yii\db\Migration;

/**
 * Class m230725_142639_create_borrowing_table
 */
class m230725_142639_create_borrowing_table extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }


        $this->createTable('{{%borrowing}}', [
            'id' => $this->primaryKey(),
            'fk_customer' => $this->integer()->notNull(),
            'fk_book' => $this->integer()->notNull(),
            'borrow_date' => $this->date()->notNull(),
            'return_date' => $this->date(),
            'created_by' => $this->integer()->notNull(),
            'updated_by' => $this->integer()->notNull(),
            'created_at' => $this->timestamp(),
            'updated_at' => $this->timestamp(),
        ], $tableOptions);

        // creates index for column `fk_customer`
        $this->createIndex(
            '{{%idx-borrowing-fk_customer}}',
            '{{%borrowing}}',
            'fk_customer'
        );

        // creates index for column `fk_book`
        $this->createIndex(
            '{{%idx-borrowing-fk_book}}',
            '{{%borrowing}}',
            'fk_book'
        );

        // creates index for column `created_by`
        $this->createIndex(
            '{{%idx-borrowing-created_by}}',
            '{{%borrowing}}',
            'created_by'
        );

        // creates index for column `updated_by`
        $this->createIndex(
            '{{%idx-borrowing-updated_by}}',
            '{{%borrowing}}',
            'updated_by'
        );

        // add foreign key for table `{{%customer}}`
        $this->addForeignKey(
            '{{%fk-borrowing-fk_customer}}',
            '{{%borrowing}}',
            'fk_customer',
            '{{%customer}}',
            'id',
            'NO ACTION'
        );

        // add foreign key for table `{{%book}}`
        $this->addForeignKey(
            '{{%fk-borrowing-fk_book}}',
            '{{%borrowing}}',
            'fk_book',
            '{{%book}}',
            'id',
            'NO ACTION'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-borrowing-created_by}}',
            '{{%borrowing}}',
            'created_by',
            '{{%user}}',
            'id',
            'CASCADE'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-borrowing-updated_by}}',
            '{{%borrowing}}',
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
            '{{%fk-borrowing-created_by}}',
            '{{%borrowing}}'
        );

        // drops index for column `created_by`
        $this->dropIndex(
            '{{%idx-borrowing-created_by}}',
            '{{%borrowing}}'
        );

        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-borrowing-updated_by}}',
            '{{%borrowing}}'
        );

        // drops index for column `updated_by`
        $this->dropIndex(
            '{{%idx-borrowing-updated_by}}',
            '{{%borrowing}}'
        );
        
        // drops foreign key for table `{{%customer}}`
        $this->dropForeignKey(
            '{{%fk-borrowing-fk_customer}}',
            '{{%borrowing}}'
        );

        // drops index for column `fk_customer`
        $this->dropIndex(
            '{{%idx-borrowing-fk_customer}}',
            '{{%borrowing}}'
        );
        
        // drops foreign key for table `{{%book}}`
        $this->dropForeignKey(
            '{{%fk-borrowing-fk_book}}',
            '{{%borrowing}}'
        );

        // drops index for column `fk_book`
        $this->dropIndex(
            '{{%idx-borrowing-fk_book}}',
            '{{%borrowing}}'
        );

        $this->dropTable('{{%borrowing}}');
    }
}
