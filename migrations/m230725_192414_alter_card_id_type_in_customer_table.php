<?php

use yii\db\Migration;

/**
 * Class m230725_192414_alter_card_id_type_in_customer_table
 */
class m230725_192414_alter_card_id_type_in_customer_table extends Migration
{
    public function safeUp()
    {
        $this->alterColumn('customer', 'card_id', $this->string(191)->notNull(),);
    }

    public function safeDown()
    {
        $this->alterColumn('customer', 'card_id', $this->integer()->notNull(),);
    }
}
