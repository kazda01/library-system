<?php

use yii\db\Migration;

class m230105_174214_init extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string(191)->notNull(),
            'auth_key' => $this->string(32)->notNull(),
            'verification_token' => $this->string(191)->defaultValue(null),
            'password_hash' => $this->string(191)->notNull(),
            'password_reset_token' => $this->string(191)->unique(),
            'email' => $this->string(191)->notNull()->unique(),
            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);
        
        
        $this->createTable('session', [
            'id' => $this->char(40)->notNull(),
            'expire' => $this->integer(),
            'data' => $this->binary(),
            'fk_user' => $this->integer()
        ], $tableOptions);

        $this->addPrimaryKey('session_pk', 'session', 'id');

        // creates index for column `fk_user`
        $this->createIndex(
            '{{%idx-session-fk_user}}',
            '{{%session}}',
            'fk_user'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-session-fk_user}}',
            '{{%session}}',
            'fk_user',
            '{{%user}}',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropForeignKey('{{%fk-session-fk_user}}', '{{%session}}');
        $this->dropIndex('{{%idx-session-fk_user}}', '{{%session}}');
        $this->dropTable('{{%user}}');
        $this->dropTable('{{%session}}');
    }
}
