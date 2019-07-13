<?php

use yii\db\Migration;

/**
 * Class m190302_112852_speakers
 */
class m190302_112852_speaker extends Migration
{
    private $table = 'speaker';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->table,[
            'id'    => $this->primaryKey(),
            'user_photo' => $this->string(255),
            'name'  => $this->string(30),
            'last_name' => $this->string(30),
            'about' => $this->text()

        ]);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190302_112852_speakers cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190302_112852_speakers cannot be reverted.\n";

        return false;
    }
    */
}
