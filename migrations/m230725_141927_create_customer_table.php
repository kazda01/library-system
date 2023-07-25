<?php

use yii\db\Migration;

/**
 * Class m230725_141927_create_customer_table
 */
class m230725_141927_create_customer_table extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }


        $this->createTable('{{%customer}}', [
            'id' => $this->primaryKey(),
            'card_id' => $this->integer()->notNull(),
            'name' => $this->string(191)->notNull(),
            'surname' => $this->string(191)->notNull(),
            'created_by' => $this->integer()->notNull(),
            'updated_by' => $this->integer()->notNull(),
            'created_at' => $this->timestamp(),
            'updated_at' => $this->timestamp(),
        ], $tableOptions);

        // creates index for column `created_by`
        $this->createIndex(
            '{{%idx-customer-created_by}}',
            '{{%customer}}',
            'created_by'
        );

        // creates index for column `updated_by`
        $this->createIndex(
            '{{%idx-customer-updated_by}}',
            '{{%customer}}',
            'updated_by'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-customer-created_by}}',
            '{{%customer}}',
            'created_by',
            '{{%user}}',
            'id',
            'CASCADE'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-customer-updated_by}}',
            '{{%customer}}',
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
            '{{%fk-customer-created_by}}',
            '{{%customer}}'
        );

        // drops index for column `created_by`
        $this->dropIndex(
            '{{%idx-customer-created_by}}',
            '{{%customer}}'
        );

        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-customer-updated_by}}',
            '{{%customer}}'
        );

        // drops index for column `updated_by`
        $this->dropIndex(
            '{{%idx-customer-updated_by}}',
            '{{%customer}}'
        );

        $this->dropTable('{{%customer}}');
    }
}
