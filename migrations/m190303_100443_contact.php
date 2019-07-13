<?php

use yii\db\Migration;

/**
 * Class m190303_100443_contact
 */
class m190303_100443_contact extends Migration
{
    private $table = 'contact';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->table,[
            'id'    => $this->primaryKey(),
            'phone' => $this->string(255),
            'email' => $this->string(255)
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190303_100443_contact cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190303_100443_contact cannot be reverted.\n";

        return false;
    }
    */
}
