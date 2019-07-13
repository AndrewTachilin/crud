<?php

use yii\db\Migration;

/**
 * Class m190303_220606_application_management
 */
class m190303_220606_application_management extends Migration
{
    private $table = 'application_management';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->table,[
            'id' => $this->primaryKey(),
            'status'    => "ENUM('new', 'active', 'disabled','payed','unpaid')",
            'date_application' => $this->date(),
            'name'  => $this->string(255),
            'phone' => $this->string(255),
            'email' => $this->string(255)
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190303_220606_application_management cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190303_220606_application_management cannot be reverted.\n";

        return false;
    }
    */
}
